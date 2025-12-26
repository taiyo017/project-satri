<?php

namespace App\Http\Controllers;

use App\Models\AppCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = AppCategory::withCount('apps');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $categories = $query->orderBy('order')->paginate(15)->withQueryString();

        return view('admin.app-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.app-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:app_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['is_active'] = $request->has('is_active');

        AppCategory::create($data);

        return redirect()->route('app-categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(AppCategory $appCategory)
    {
        return view('admin.app-categories.edit', compact('appCategory'));
    }

    public function update(Request $request, AppCategory $appCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:app_categories,slug,' . $appCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['is_active'] = $request->has('is_active');

        $appCategory->update($data);

        return redirect()->route('app-categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(AppCategory $appCategory)
    {
        if ($appCategory->apps()->count() > 0) {
            return redirect()->route('app-categories.index')
                ->with('error', 'Cannot delete category with existing apps. Please reassign or delete the apps first.');
        }

        $appCategory->delete();

        return redirect()->route('app-categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
