<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSyllabus;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($slug)
    {
        $course = Course::with('category')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $syllabi = CourseSyllabus::where('course_id', $course->id)->get();

        return view('frontend.courses.show', compact('course', 'syllabi'));
    }
}
