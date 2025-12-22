<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailCampaign;
use App\Models\SubscriptionTopic;
use App\Services\EmailNotificationService;
use Illuminate\Http\Request;

class EmailCampaignController extends Controller
{
    public function __construct(
        private EmailNotificationService $notificationService
    ) {}

    public function index()
    {
        $campaigns = EmailCampaign::with('topic')->latest()->paginate(20);
        return view('admin.email-campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $topics = SubscriptionTopic::active()->get();
        return view('admin.email-campaigns.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subscription_topic_id' => 'required|exists:subscription_topics,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,scheduled',
            'scheduled_at' => 'nullable|required_if:status,scheduled|date|after:now',
        ]);

        $campaign = EmailCampaign::create($validated);

        return redirect()->route('admin.email-campaigns.show', $campaign)
            ->with('success', 'Campaign created successfully.');
    }

    public function show(EmailCampaign $emailCampaign)
    {
        $emailCampaign->load(['topic', 'emailLogs' => function ($query) {
            $query->latest()->limit(100);
        }]);

        return view('admin.email-campaigns.show', compact('emailCampaign'));
    }

    public function edit(EmailCampaign $emailCampaign)
    {
        if ($emailCampaign->status !== 'draft') {
            return redirect()->route('admin.email-campaigns.show', $emailCampaign)
                ->with('error', 'Only draft campaigns can be edited.');
        }

        $topics = SubscriptionTopic::active()->get();
        return view('admin.email-campaigns.edit', compact('emailCampaign', 'topics'));
    }

    public function update(Request $request, EmailCampaign $emailCampaign)
    {
        if ($emailCampaign->status !== 'draft') {
            return redirect()->route('admin.email-campaigns.show', $emailCampaign)
                ->with('error', 'Only draft campaigns can be edited.');
        }

        $validated = $request->validate([
            'subscription_topic_id' => 'required|exists:subscription_topics,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,scheduled',
            'scheduled_at' => 'nullable|required_if:status,scheduled|date|after:now',
        ]);

        $emailCampaign->update($validated);

        return redirect()->route('admin.email-campaigns.show', $emailCampaign)
            ->with('success', 'Campaign updated successfully.');
    }

    public function send(EmailCampaign $emailCampaign)
    {
        if (!in_array($emailCampaign->status, ['draft', 'scheduled'])) {
            return redirect()->back()
                ->with('error', 'This campaign cannot be sent.');
        }

        $this->notificationService->sendCampaignToTopic($emailCampaign->id);

        return redirect()->route('admin.email-campaigns.show', $emailCampaign)
            ->with('success', 'Campaign is being sent to subscribers.');
    }

    public function destroy(EmailCampaign $emailCampaign)
    {
        if ($emailCampaign->status === 'sending') {
            return redirect()->back()
                ->with('error', 'Cannot delete a campaign that is currently being sent.');
        }

        $emailCampaign->delete();

        return redirect()->route('admin.email-campaigns.index')
            ->with('success', 'Campaign deleted successfully.');
    }
}
