<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    /**
     * Display gallery index with stats
     */
    public function index()
    {
        $images = Gallery::latest()->paginate(24);

        // Optimized stats query using single query
        $stats = [
            'totalImages' => Gallery::count(),
            'activeCount' => Gallery::where('is_active', true)->count(),
            'inactiveCount' => Gallery::where('is_active', false)->count(),
            'trashedCount' => Gallery::onlyTrashed()->count(),
        ];

        return view('admin.gallery.index', array_merge(compact('images'), $stats));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = GalleryCategory::where('is_active', true)->get();
        return view('admin.gallery.create', compact('categories'));
    }

    /**
     * Store new gallery image
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'nullable|exists:gallery_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Upload image
            $imagePath = $request->file('image')->store('galleries', 'public');

            // Create gallery
            Gallery::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'category_id' => $validated['category_id'] ?? null,
                'image' => $imagePath,
                'is_active' => $request->boolean('is_active'),
                'order' => $validated['order'] ?? 0,
            ]);

            DB::commit();
            return redirect()
                ->route('galleries.index')
                ->with('success', 'Gallery image added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up uploaded file if exists
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to create gallery: ' . $e->getMessage());
        }
    }

    public function show(Request $request, Gallery $gallery)
    {
        // If client expects JSON (API/AJAX), return gallery data
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $gallery->id,
                    'title' => $gallery->title,
                    'image' => $gallery->image,
                    'description' => $gallery->description,
                    'is_active' => $gallery->is_active,
                    'category_id' => $gallery->category_id,
                    'created_at' => optional($gallery->created_at)->toISOString(),
                    'updated_at' => optional($gallery->updated_at)->toISOString(),
                ],
            ]);
        }

        // For normal browser GET /galleries/{id} — redirect to edit (or show view if you prefer)
        return redirect()->route('galleries.index');
    }

    /**
     * Show edit form
     */
    public function edit(Gallery $gallery)
    {
        $categories = GalleryCategory::where('is_active', true)->get();
        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    /**
     * Update gallery
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'nullable|exists:gallery_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
            'link' => 'nullable|url|max:500',
        ]);

        DB::beginTransaction();
        try {
            $oldImage = $gallery->image;

            // Handle new image upload
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('galleries', 'public');
            }

            // Update gallery
            $gallery->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'category_id' => $validated['category_id'] ?? null,
                'image' => $validated['image'] ?? $gallery->image,
                'is_active' => $request->boolean('is_active'),
                'order' => $validated['order'] ?? 0,
                'link' => $validated['link'] ?? null,
            ]);

            // Delete old image if new one was uploaded
            if (isset($validated['image']) && $oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();
            return redirect()
                ->route('galleries.index')
                ->with('success', 'Gallery updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up new image if exists
            if (isset($validated['image']) && Storage::disk('public')->exists($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to update gallery: ' . $e->getMessage());
        }
    }

    /**
     * Soft delete single gallery
     */


    public function trash($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            $gallery->delete();

            return redirect()
                ->route('galleries.index')
                ->with('success', 'Image moved to trash successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to move image to trash: ' . $e->getMessage());
        }
    }

    /**
     * Bulk soft delete galleries
     */
    public function bulkTrash(Request $request)
    {
        $request->validate([
            'ids' => 'required|string'
        ]);

        try {
            $ids = array_filter(explode(',', $request->ids));
            $count = Gallery::whereIn('id', $ids)->delete();

            return redirect()
                ->route('galleries.index')
                ->with('success', "{$count} image(s) moved to trash successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to move images to trash: ' . $e->getMessage());
        }
    }

    /**
     * Get trashed galleries (AJAX)
     */
    public function trashIndex()
    {
        try {
            $trashedImages = Gallery::onlyTrashed()
                ->orderBy('deleted_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $trashedImages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Restore single gallery
     */
    public function restore($id)
    {
        try {
            $gallery = Gallery::onlyTrashed()->findOrFail($id);
            $gallery->restore();

            return response()->json([
                'success' => true,
                'message' => 'Image restored successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Permanently delete single gallery
     */
    public function forceDelete($id)
    {
        try {
            $gallery = Gallery::onlyTrashed()->findOrFail($id);

            // Delete physical file
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            $gallery->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Image permanently deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Empty entire trash
     */
    public function emptyTrash()
    {
        try {
            $trashedImages = Gallery::onlyTrashed()->get();
            $count = $trashedImages->count();

            if ($count === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Trash is already empty!'
                ]);
            }

            // Delete all files and records
            foreach ($trashedImages as $gallery) {
                if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                    Storage::disk('public')->delete($gallery->image);
                }
                $gallery->forceDelete();
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$count} image(s) permanently!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to empty trash: ' . $e->getMessage()
            ], 500);
        }
    }
}
