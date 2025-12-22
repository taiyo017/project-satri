<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\SubscriptionTopic;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::with('topics');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Topic filter
        if ($request->filled('topic')) {
            $query->whereHas('topics', function ($q) use ($request) {
                $q->where('subscription_topics.id', $request->topic);
            });
        }

        // Date filter
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }

        $subscribers = $query->latest()->paginate(10)->withQueryString();
        $topics = SubscriptionTopic::all();

        return view('admin.subscribers.index', compact('subscribers', 'topics'));
    }

    public function show(Subscriber $subscriber)
    {
        $subscriber->load(['topics', 'emailLogs' => function ($query) {
            $query->latest()->limit(50);
        }]);

        return view('admin.subscribers.show', compact('subscriber'));
    }

    public function updateStatus(Request $request, Subscriber $subscriber)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,unsubscribed,bounced',
        ]);

        $subscriber->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Subscriber status updated successfully.');
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Subscriber::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('topic')) {
            $query->whereHas('topics', function ($q) use ($request) {
                $q->where('subscription_topics.id', $request->topic);
            });
        }

        return (new \App\Exports\SubscribersExport($query))->download('subscribers.xlsx');
    }
}
