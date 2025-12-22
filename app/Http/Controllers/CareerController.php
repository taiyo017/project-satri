<?php

namespace App\Http\Controllers;

use App\Events\JobPosted;
use App\Mail\ForwardApplicationEmail;
use App\Models\Career;
use App\Models\CareerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CareerController extends Controller
{

    public function index(Request $request)
    {
        $query = Career::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('jobCategory', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter (active/expired)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where(function ($q) {
                    $q->whereNull('deadline')
                        ->orWhere('deadline', '>=', now());
                });
            } elseif ($request->status === 'expired') {
                $query->where('deadline', '<', now());
            }
        }

        // Job category filter
        if ($request->filled('category')) {
            $query->where('job_category_id', $request->category);
        }

        // Open/Closed filter
        if ($request->filled('is_open')) {
            $query->where('is_open', $request->is_open);
        }

        $careers = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Get job categories for filter dropdown
        $jobCategories = \App\Models\JobCategory::orderBy('name')->get();
        
        return view('admin.careers.index', compact('careers', 'jobCategories'));
    }


    /**
     * Admin: Show form to create career
     */
    public function create()
    {
        $jobCategories = \App\Models\JobCategory::orderBy('name')->get();
        return view('admin.careers.create', compact('jobCategories'));
    }

    /**
     * Admin: Store new career
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:careers,slug',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'deadline' => 'nullable|date|after_or_equal:today',
            'is_open' => 'required|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $career = Career::create($validated);

        // Trigger event to notify subscribers
        event(new JobPosted($career));

        return redirect()->route('careers.index')->with('success', 'Career created successfully.');
    }

    public function show(Career $career)
    {
        $applications = $career->applications()->orderBy('created_at', 'desc')->get();
        return view('admin.careers.show', compact('career', 'applications'));
    }

    /**
     * Admin: Show edit form
     */
    public function edit(Career $career)
    {
        $jobCategories = \App\Models\JobCategory::orderBy('name')->get();
        return view('admin.careers.edit', compact('career', 'jobCategories'));
    }

    /**
     * Admin: Update career
     */
    public function update(Request $request, Career $career)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:careers,slug,' . $career->id,
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'deadline' => 'nullable|date',
            'is_open' => 'required|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $career->update($validated);

        return redirect()->route('careers.index')->with('success', 'Career updated successfully.');
    }

    /**
     * Admin: Delete career
     */
    public function destroy(Career $career)
    {
        $career->delete();
        return redirect()->route('careers.index')->with('success', 'Career deleted successfully.');
    }

    public function markAsRead(CareerApplication $application)
    {
        $application->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function forwardEmail(Request $request, CareerApplication $application)
    {
        $application->load('career'); // ensure career is loaded

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            Mail::to($application->email)->send(
                new ForwardApplicationEmail(
                    $application,
                    $request->subject,
                    $request->message
                )
            );

            $application->update(['is_read' => true]);

            return redirect()->back()->with('success', 'Email sent successfully to ' . $application->name);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email. Please try again. ' . $e->getMessage());
        }
    }
}
