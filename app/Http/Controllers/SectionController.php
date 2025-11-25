<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Services\SectionTemplateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{

    // Add a new section
    public function store(Request $request, Page $page)
    {
        $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(config('sections')))
        ]);

        DB::beginTransaction();
        try {
            $section = SectionTemplateService::createSectionFromTemplate($page, $request->type);

            DB::commit();

            return response()->json([
                'message' => 'Section added successfully',
                'section' => $section->load('fields')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Section creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => $e->getMessage(),
                'error' => 'Failed to create section'
            ], 500);
        }
    }



    // Delete a section
    public function destroy(Section $section)
    {
        DB::beginTransaction();
        try {
            // Delete associated images
            foreach ($section->fields as $field) {
                if (in_array($field->field_type, ['image', 'file']) && $field->field_value) {
                    $this->deleteFile($field->field_value);
                } elseif ($field->field_type === 'repeater') {
                    $value = json_decode($field->field_value, true);
                    if (is_array($value)) {
                        foreach ($value as $item) {
                            foreach ($item as $key => $val) {
                                if (is_string($val) && str_contains($val, '/storage/')) {
                                    $this->deleteFile($val);
                                }
                            }
                        }
                    }
                }
            }

            $section->fields()->delete();
            $section->delete();

            DB::commit();

            return response()->json([
                'message' => 'Section deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Section deletion failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to delete section',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    // Reorder sections via AJAX
    public function reorder(Request $request, Section $section)
    {
        $request->validate(['order_index' => 'required|integer']);
        $section->update(['order_index' => $request->order_index]);

        return response()->json(['success' => true]);
    }


    // Update section fieldspublic function update(Request $request, Section $section)
    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'fields' => 'required|array',
            'fields.*.id' => 'required|integer|exists:section_fields,id',
            'fields.*.field_value' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['fields'] as $fieldData) {
                $field = $section->fields()->where('id', $fieldData['id'])->first();

                if ($field) {
                    $value = $fieldData['field_value'];

                    // Keep repeater fields as JSON strings
                    if ($field->field_type === 'repeater' && is_array($value)) {
                        $value = json_encode($value);
                    }

                    $field->update([
                        'field_value' => $value
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Section updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Section update failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to update section',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    private function deleteFile($url)
    {
        try {
            $path = str_replace('/storage/', '', parse_url($url, PHP_URL_PATH));
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete file: ' . $e->getMessage());
        }
    }
}
