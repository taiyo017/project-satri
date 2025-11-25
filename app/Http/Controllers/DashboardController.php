<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get stats in a single efficient query for each model
        $stats = [
            'pages' => Page::count(),
            'sections' => Section::count(),
            'unread_messages' => Contact::where('is_read', false)->count(),
            'total_messages' => Contact::count(),
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

        // Build activity timeline efficiently
        $activities = $this->getRecentActivities($recentPages, $newMessages);

        return view('admin.dashboard', compact(
            'stats',
            'recentPages',
            'newMessages',
            'activities'
        ));
    }

    /**
     * Combine and sort recent activities
     */
    private function getRecentActivities($pages, $messages)
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

        // Sort by time (descending) and limit to 10
        return $activities->sortByDesc('time')->take(10)->values();
    }
}
