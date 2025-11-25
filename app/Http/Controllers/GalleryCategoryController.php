<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of categories (admin)
     */
    public function index()
    {
        $categories = GalleryCategory::latest()->paginate();
        return view('admin.gallery_category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.gallery_category.create');
    }

    /**
     * Store a newly created category in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        GalleryCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('gallery-categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing a category
     */
    public function edit(GalleryCategory $galleryCategory)
    {
        $category = GalleryCategory::findOrFail($galleryCategory->id);
        return view('admin.gallery_category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage
     */
    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $galleryCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('gallery-categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage (soft delete)
     */
    public function destroy(GalleryCategory $galleryCategory)
    {
        $galleryCategory->delete();

        return redirect()->route('gallery-categories.index')->with('success', 'Category deleted successfully.');
    }
}
