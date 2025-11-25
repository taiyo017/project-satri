<?php

namespace App\Http\Controllers;

use App\Models\SectionField;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SectionFieldController extends Controller
{
    public function update(Request $request, SectionField $field)
    {
        $field->update(['field_value' => $request->value]);
        return response()->json(['message' => 'Field updated']);
    }

    public function upload(Request $request, $fieldId)
    {
        // Find the field or fail
        $field = SectionField::findOrFail($fieldId);

        // Make sure this is an image field
        if ($field->field_type !== 'image') {
            return response()->json([
                'success' => false,
                'message' => 'This field is not an image.',
            ], 400);
        }

        // Validate the uploaded image
        $request->validate([
            'image' => 'required|file|mimes:jpeg,jpg,png,gif,webp,svg|max:5120', // 5MB max
        ], [
            'image.required' => 'Please select an image to upload.',
            'image.mimes' => 'Only JPEG, PNG, GIF, WEBP, or SVG files are allowed.',
            'image.max' => 'Image size must not exceed 5MB.',
        ]);

        // Check file validity
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image.',
            ], 400);
        }

        $file = $request->file('image');

        // Clean original filename to remove unsafe characters
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $name = preg_replace('/[^A-Za-z0-9\-]/', '_', $name);
        $extension = $file->getClientOriginalExtension();

        // Generate filename with timestamp for uniqueness
        $filename = $name . '_' . time() . '.' . $extension;

        // Delete old image if exists
        if ($field->field_value && Storage::disk('public')->exists($field->field_value)) {
            Storage::disk('public')->delete($field->field_value);
        }

        // Store the new file in public disk under 'sections/'
        $path = $file->storeAs('sections', $filename, 'public');

        // Save relative path in DB
        $field->field_value = $path;
        $field->save();

        // Return response with relative path and public URL
        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully.',
            'path' => $path, // relative path for DB
            'url' => asset('storage/' . $path), // full URL for frontend
        ], 200);
    }


    public function addRepeaterItem(Request $request, $sectionId)
    {
        $field = SectionField::findOrFail($request->field_id);
        $items = json_decode($field->field_value, true) ?? [];
        $items[] = $request->new_item;

        $field->field_value = json_encode($items);
        $field->save();

        return response()->json(['success' => true, 'items' => $items]);
    }

    public function deleteRepeaterItem($fieldId, $itemId)
    {
        $field = SectionField::findOrFail($fieldId);
        $items = json_decode($field->field_value, true) ?? [];
        unset($items[$itemId]);
        $field->field_value = json_encode(array_values($items));
        $field->save();

        return response()->json(['success' => true, 'items' => $items]);
    }
}
