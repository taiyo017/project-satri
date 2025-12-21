<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Course;
use App\Models\CourseApplication;
use App\Models\CareerApplication;
use App\Models\Page;
use App\Models\Project;
use App\Models\Section;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get stats in a single efficient query for each model
        $stats = [
            'pages' => Page::count(),
            'sections' => Section::count(),
            'team' => TeamMember::count(),
            'projects' => Project::count(),
            'courses' => Course::count(),
            'unread_messages' => Contact::where('is_read', false)->count(),
            'total_messages' => Contact::count(),
            'career_applications' => CareerApplication::count(),
            'unread_career_applications' => CareerApplication::where('is_read', false)->count(),
            'course_applications' => CourseApplication::count(),
            'unread_course_applications' => CourseApplication::where('is_read', false)->count(),
        ];

        // Get recent pages (latest 5)
        $recentPages = Page::latest()
            ->take(5)
            ->select('id', 'title', 'created_at')
            ->get();

        // Get unread messages (latest 5)
        $newMessages = Contact::where('is_read', false)
            ->latest()
            ->take(5)
            ->select('id', 'subject', 'created_at')
            ->get();

        // Get recent career applications (latest 5)
        $recentCareerApplications = CareerApplication::with('career:id,title')
            ->latest()
            ->take(5)
            ->select('id', 'career_id', 'name', 'email', 'is_read', 'created_at')
            ->get();

        // Get recent course applications (latest 5)
        $recentCourseApplications = CourseApplication::with('course:id,title')
            ->latest()
            ->take(5)
            ->select('id', 'course_id', 'name', 'email', 'is_read', 'created_at')
            ->get();

        // Build activity timeline efficiently
        $activities = $this->getRecentActivities($recentPages, $newMessages, $recentCareerApplications, $recentCourseApplications);

        return view('admin.dashboard', compact(
            'stats',
            'recentPages',
            'newMessages',
            'recentCareerApplications',
            'recentCourseApplications',
            'activities'
        ));
    }

    /**
     * Combine and sort recent activities
     */
    private function getRecentActivities($pages, $messages, $careerApps, $courseApps)
    {
        $activities = collect();

        // Add pages to activities
        foreach ($pages as $page) {
            $activities->push([
                'type' => 'page',
                'title' => $page->title,
                'time' => $page->created_at,
            ]);
        }

        // Add messages to activities
        foreach ($messages as $message) {
            $activities->push([
                'type' => 'message',
                'title' => $message->subject ?? 'No Subject',
                'time' => $message->created_at,
            ]);
        }

        // Add career applications to activities
        foreach ($careerApps as $app) {
            $activities->push([
                'type' => 'career_application',
                'title' => $app->name . ' applied for ' . ($app->career->title ?? 'Unknown Position'),
                'time' => $app->created_at,
                'is_read' => $app->is_read,
            ]);
        }

        // Add course applications to activities
        foreach ($courseApps as $app) {
            $activities->push([
                'type' => 'course_application',
                'title' => $app->name . ' enrolled in ' . ($app->course->title ?? 'Unknown Course'),
                'time' => $app->created_at,
                'is_read' => $app->is_read,
            ]);
        }

        // Sort by time (descending) and limit to 10
        return $activities->sortByDesc('time')->take(10)->values();
    }
}
