<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailCampaign;
use App\Models\SubscriptionTopic;
use App\Services\EmailAnalyticsService;

class EmailAnalyticsController extends Controller
{
    public function __construct(
        private EmailAnalyticsService $analyticsService
    ) {}

    public function index()
    {
        $analytics = $this->analyticsService->getOverallAnalytics();
        $recentCampaigns = EmailCampaign::with('topic')
            ->where('status', 'sent')
            ->latest('sent_at')
            ->limit(10)
            ->get();

        return view('admin.email-analytics.index', compact('analytics', 'recentCampaigns'));
    }

    public function campaign(EmailCampaign $emailCampaign)
    {
        $analytics = $this->analyticsService->getCampaignAnalytics($emailCampaign->id);
        
        return view('admin.email-analytics.campaign', compact('analytics'));
    }

    public function topic(SubscriptionTopic $subscriptionTopic)
    {
        $analytics = $this->analyticsService->getTopicAnalytics($subscriptionTopic->id);
        
        return view('admin.email-analytics.topic', compact('analytics'));
    }
}
