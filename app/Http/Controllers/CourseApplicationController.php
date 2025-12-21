<?php

namespace App\Http\Controllers;

use App\Models\CourseApplication;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseApplicationController extends Controller
{
    public function store(Request $request, $course_id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'resume'       => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'message'      => 'nullable|string',
        ]);

        $course = Course::findOrFail($course_id);
        $data = $request->only(['name', 'email', 'phone', 'message']);
        $data['course_id'] = $course_id;

        if ($request->hasFile('resume')) {
            $data['resume'] = $request->file('resume')->store('course_resumes', 'public');
        }

        if ($request->hasFile('cover_letter')) {
            $data['cover_letter'] = $request->file('cover_letter')->store('course_cover_letters', 'public');
        }

        CourseApplication::create($data);

        return redirect()->back()->with('success', 'Your application has been submitted successfully.');
    }

    /**
     * Export applications to CSV
     */
    public function export(Course $course)
    {
        $applications = $course->applications()->get();

        $filename = Str::slug($course->title) . '-applications-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($applications) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'Name',
                'Email',
                'Phone',
                'Message',
                'Status',
                'Applied At',
                'Resume',
                'Cover Letter'
            ]);

            // Data rows
            foreach ($applications as $application) {
                fputcsv($file, [
                    $application->name,
                    $application->email,
                    $application->phone,
                    $application->message,
                    $application->is_read ? 'Read' : 'Unread',
                    $application->created_at->format('Y-m-d H:i:s'),
                    $application->resume ? asset('storage/' . $application->resume) : 'N/A',
                    $application->cover_letter ? asset('storage/' . $application->cover_letter) : 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
