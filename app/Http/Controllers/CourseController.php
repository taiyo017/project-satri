<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSyllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $courses = Course::with('category')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $categories = CourseCategory::all();
        return view('admin.courses.create', compact('categories'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'       => 'required|exists:course_categories,id',
            'title'             => 'required|string|max:255',
            'slug'              => 'nullable|string|unique:courses,slug',
            'short_description' => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'price'             => 'nullable|numeric|min:0',
            'duration'          => 'nullable|string|max:50',
            'is_featured'       => 'nullable|boolean',
            'status'            => 'nullable|boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keywords'     => 'nullable|string',
            'image'             => 'nullable|image|max:2048',
            'syllabus'          => 'nullable|array',
            'syllabus.*.title'  => 'required|string|max:255',
            'syllabus.*.content' => 'nullable|string',
            'syllabus.*.file_path'   => 'required|file|mimes:pdf,doc,docx',
        ]);

        // Handle image
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }

        // Booleans
        $data['is_featured'] = $request->has('is_featured');
        $data['status'] = $request->has('status');

        $course = Course::create($data);

        // Handle syllabus
        if ($request->filled('syllabus')) {
            foreach ($request->syllabus as $item) {
                $syllabusData = [
                    'title'   => $item['title'],
                    'content' => $item['content'] ?? null,
                ];

                if (isset($item['file_path'])) {
                    $syllabusData['file_path'] = $item['file_path']->store('syllabus', 'public');
                }

                $course->syllabus()->create($syllabusData);
            }
        }

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully!');
    }


    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $categories = CourseCategory::all();
        $course->load('syllabus'); // eager load

        $courseSyllabuses = $course->syllabus; // pass to view
        return view('admin.courses.edit', compact('course', 'categories', 'courseSyllabuses'));
    }


    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'category_id'       => 'required|exists:course_categories,id',
            'title'             => 'required|string|max:255',
            'slug'              => 'nullable|string|unique:courses,slug,' . $course->id,
            'short_description' => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'price'             => 'nullable|numeric|min:0',
            'duration'          => 'nullable|string|max:50',
            'is_featured'       => 'nullable|boolean',
            'status'            => 'nullable|boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keywords'     => 'nullable|string',
            'image'             => 'nullable|image|max:2048',
            'syllabus'          => 'nullable|array',
            'syllabus.*.id'     => 'nullable|exists:course_syllabuses,id',
            'syllabus.*.title'  => 'required|string|max:255',
            'syllabus.*.content' => 'nullable|string',
            'syllabus.*.file_path'   => 'required|file|mimes:pdf,doc,docx',
        ]);

        // Handle image
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['status'] = $request->has('status');

        $course->update($data);

        // Sync syllabus
        $existingIds = $course->syllabus()->pluck('id')->toArray();
        $inputIds = collect($request->syllabus ?? [])->pluck('id')->filter()->toArray();

        // Delete removed syllabus
        CourseSyllabus::whereIn('id', array_diff($existingIds, $inputIds))->delete();

        // Update or create syllabus
        foreach ($request->syllabus ?? [] as $item) {
            $syllabusData = [
                'title'   => $item['title'],
                'content' => $item['content'] ?? null,
            ];

            if (isset($item['file_path'])) {
                $syllabusData['file_path'] = $item['file_path']->store('syllabus', 'public');
            }

            if (!empty($item['id'])) {
                $course->syllabus()->find($item['id'])->update($syllabusData);
            } else {
                $course->syllabus()->create($syllabusData);
            }
        }

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully!');
    }


    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
