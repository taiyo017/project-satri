<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\AppCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
    public function index(Request $request)
    {
        $query = App::with(['category', 'latestVersion'])->withCount('downloads');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('app_category_id', $request->category);
        }

        $apps = $query->latest()->paginate(12)->withQueryString();
        $categories = AppCategory::where('is_active', true)->orderBy('order')->get();

        return view('admin.apps.index', compact('apps', 'categories'));
    }

    public function create()
    {
        $categories = AppCategory::where('is_active', true)->orderBy('order')->get();
        return view('admin.apps.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:apps,slug',
            'app_category_id' => 'nullable|exists:app_categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'package_name' => 'nullable|string|max:255',
            'icon' => 'nullable|image|max:2048',
            'is_featured' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive,draft',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('apps/icons', 'public');
        }

        $app = App::create($data);

        // Redirect to show page where user can add versions, files, screenshots
        return redirect()->route('apps.show', $app)
            ->with('success', 'App created successfully! Now add versions and files below.');
    }

    public function show(App $app)
    {
        $app->load(['category', 'versions.files', 'screenshots', 'qrCode']);
        return view('admin.apps.show', compact('app'));
    }

    public function edit(App $app)
    {
        $categories = AppCategory::where('is_active', true)->orderBy('order')->get();
        return view('admin.apps.edit', compact('app', 'categories'));
    }

    public function update(Request $request, App $app)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:apps,slug,' . $app->id,
            'app_category_id' => 'nullable|exists:app_categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'package_name' => 'nullable|string|max:255',
            'icon' => 'nullable|image|max:2048',
            'is_featured' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive,draft',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('icon')) {
            if ($app->icon) {
                Storage::disk('public')->delete($app->icon);
            }
            $data['icon'] = $request->file('icon')->store('apps/icons', 'public');
        }

        $app->update($data);

        return redirect()->route('apps.show', $app)
            ->with('success', 'App updated successfully!');
    }

    public function destroy(App $app)
    {
        if ($app->icon) {
            Storage::disk('public')->delete($app->icon);
        }

        $app->delete();

        return redirect()->route('apps.index')
            ->with('success', 'App deleted successfully!');
    }
}
