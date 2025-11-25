<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->paginate();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $type = DB::select("SHOW COLUMNS FROM pages WHERE Field = 'status'")[0]->Type;

        preg_match("/^enum\('(.*)'\)$/", $type, $matches);
        $statuses = array_combine(explode("','", $matches[1]), explode("','", $matches[1]));

        return view('admin.pages.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:pages,slug',
            'featured_image' => 'nullable|image',
            'status' => 'required|in:draft,published,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string',
            'twitter_image' => 'nullable|image',
        ]);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('pages', 'public');
        }
        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $request->file('twitter_image')->store('pages', 'public');
        }

        Page::create($data);
        return redirect()->route('pages.index')->with('success', 'Page created successfully!');
    }

    public function show(Page $page)
    {
        $sections = $page->sections()->with('fields')->orderBy('order_index')->get();
        $sectionTypes = config('sections');

        return view('admin.pages.show', compact('page', 'sections', 'sectionTypes'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:pages,slug,' . $page->id,
            'featured_image' => 'nullable|image',
            'status' => 'required|in:draft,published,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string',
            'twitter_image' => 'nullable|image',
        ]);


        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('pages', 'public');
        }
        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $request->file('twitter_image')->store('pages', 'public');
        }


        $page->update($data);
        return redirect()->route('pages.index')->with('success', 'Page updated successfully!');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted successfully!');
    }
}
