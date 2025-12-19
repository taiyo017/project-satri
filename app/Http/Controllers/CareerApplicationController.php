<?php

namespace App\Http\Controllers;

use App\Mail\ForwardApplicationEmail;
use App\Models\CareerApplication;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class CareerApplicationController extends Controller
{
    public function store(Request $request, $career_id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'resume'       => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'message'      => 'nullable|string',
        ]);


        $career = Career::findOrFail($career_id);
        $data = $request->only(['name', 'email', 'phone', 'message']);
        $data['career_id'] = $career_id;

        if ($request->hasFile('resume')) {
            $data['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        if ($request->hasFile('cover_letter')) {
            $data['cover_letter'] = $request->file('cover_letter')->store('cover_letters', 'public');
        }

        CareerApplication::create($data);

        return redirect()->back()->with('success', 'Your application has been submitted successfully.');
    }



    /**
     * Export applications to CSV
     */
    public function export(Career $career)
    {
        $applications = $career->applications()->get();

        $filename = Str::slug($career->title) . '-applications-' . now()->format('Y-m-d') . '.csv';


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
