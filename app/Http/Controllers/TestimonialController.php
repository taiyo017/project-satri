<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'is_featured' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $data['is_featured'] = $request->has('is_featured');

        Testimonial::create($data);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial created successfully!');
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'is_featured' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($testimonial->photo) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $data['is_featured'] = $request->has('is_featured');

        $testimonial->update($data);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully!');
    }

    public function destroy(Testimonial $testimonial)
    {
        // Delete photo if exists
        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();
        
        return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted successfully!');
    }
}
