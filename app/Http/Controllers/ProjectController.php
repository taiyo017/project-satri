<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }


    public function store(Request $request)
    {
        // dd(123);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:projects,slug',
            'client' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:10240',
            'project_url' => 'nullable|url|max:255',
            'tech_stack' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|max:10240',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string',
            'twitter_image' => 'nullable|image|max:10240',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        // Upload images if present
        foreach (['image', 'og_image', 'twitter_image'] as $img) {
            if ($request->hasFile($img)) {
                $validated[$img] = $request->file($img)->store('projects', 'public');
            }
        }

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:projects,slug,' . $project->id,
            'client' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'project_url' => 'nullable|url|max:255',
            'tech_stack' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|max:10240',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string',
            'twitter_image' => 'nullable|image|max:10240',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ], [
            'image.image' => 'The main image must be a valid image file.',
            'image.mimes' => 'The main image must be a JPG, PNG, GIF, or WEBP file.',
            'image.max' => 'The main image must not exceed 2MB.',

            'og_image.image' => 'The OG image must be a valid image file.',
            'og_image.max' => 'The OG image must not exceed 10MB.',

            'twitter_image.image' => 'The Twitter image must be a valid image file.',
            'twitter_image.max' => 'The Twitter image must not exceed 10MB.',
        ]);

        foreach (['image', 'og_image', 'twitter_image'] as $img) {
            if ($request->hasFile($img)) {

                // delete old
                if ($project->$img && Storage::disk('public')->exists($project->$img)) {
                    Storage::disk('public')->delete($project->$img);
                }

                // upload new
                $validated[$img] = $request->file($img)->store('projects', 'public');
            }
        }

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }



    public function destroy(Project $project)
    {
        if ($project->image && Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
