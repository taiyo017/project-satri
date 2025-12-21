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

        $courses = $slug === 'our-courses'
            ? \App\Models\Course::where('status', true)->paginate(12)
            : collect();

        $projects = $slug === 'our-projects'
            ? \App\Models\Project::where('status', true)->paginate(12)
            : collect();

        $galleries = $slug === 'gallery'
            ? \App\Models\Gallery::where('is_active', true)->paginate(12)
            : collect();

        $testimonials = $slug === 'testimonial'
            ? \App\Models\Testimonial::where('status', 'active')->paginate(12)
            : collect();

        $services = $slug === 'service'
            ? \App\Models\Service::where('status', 'published')->paginate(12)
            : collect();

        return view('frontend.pages.show', compact(['page', 'courses', 'projects', 'galleries', 'testimonials', 'services']));
    }
}
