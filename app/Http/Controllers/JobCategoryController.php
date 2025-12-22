<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = JobCategory::withCount('careers');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.job_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.job_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:job_categories,slug',
            'description' => 'nullable|string',
        ]);

        JobCategory::create([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('job-categories.index')->with('success', 'Job category created successfully.');
    }

    public function edit(JobCategory $jobCategory)
    {
        return view('admin.job_categories.edit', compact('jobCategory'));
    }

    public function update(Request $request, JobCategory $jobCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:job_categories,slug,' . $jobCategory->id,
            'description' => 'nullable|string',
        ]);

        $jobCategory->update([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('job-categories.index')->with('success', 'Job category updated successfully.');
    }

    public function destroy(JobCategory $jobCategory)
    {
        if ($jobCategory->careers()->count() > 0) {
            return redirect()->route('job-categories.index')->with('error', 'Cannot delete category with associated careers.');
        }

        $jobCategory->delete();
        return redirect()->route('job-categories.index')->with('success', 'Job category deleted successfully.');
    }
}
