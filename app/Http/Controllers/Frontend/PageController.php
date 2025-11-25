<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::with(['sections' => function ($query) {
            $query->orderBy('order_index');
        }])->where('slug', $slug)->firstOrFail();

        $courses = $slug === 'our-courses' ? \App\Models\Course::where('status', true)->get() : collect();
        $projects = $slug === 'our-projects' ? \App\Models\Project::where('status', true)->get() : collect();
        $galleries = $slug === 'gallery' ? \App\Models\Gallery::where('is_active', true)->get() : collect();

        return view('frontend.pages.show', compact(['page', 'courses', 'projects', 'galleries']));
    }
}
