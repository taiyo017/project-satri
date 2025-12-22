<?php

namespace App\Services;

use App\Models\EmailCampaign;
use App\Models\EmailLog;
use App\Models\SubscriptionTopic;
use Illuminate\Support\Facades\DB;

class EmailAnalyticsService
{
    public function getCampaignAnalytics(int $campaignId): array
    {
        $campaign = EmailCampaign::with('emailLogs')->findOrFail($campaignId);

        $totalSent = $campaign->sent_count;
        $totalOpened = $campaign->emailLogs()->whereNotNull('opened_at')->count();
        $totalClicked = $campaign->emailLogs()->where('click_count', '>', 0)->count();
        $uniqueOpens = $campaign->emailLogs()->whereNotNull('opened_at')->distinct('subscriber_id')->count();

        return [
            'campaign' => $campaign,
            'total_sent' => $totalSent,
            'total_opened' => $totalOpened,
            'total_clicked' => $totalClicked,
            'unique_opens' => $uniqueOpens,
            'open_rate' => $totalSent > 0 ? round(($totalOpened / $totalSent) * 100, 2) : 0,
            'click_rate' => $totalSent > 0 ? round(($totalClicked / $totalSent) * 100, 2) : 0,
            'click_through_rate' => $totalOpened > 0 ? round(($totalClicked / $totalOpened) * 100, 2) : 0,
        ];
    }

    public function getTopicAnalytics(int $topicId): array
    {
        $topic = SubscriptionTopic::with('campaigns')->findOrFail($topicId);

        $totalSubscribers = $topic->subscribers()->count();
        $activeSubscribers = $topic->activeSubscribers()->count();
        $totalCampaigns = $topic->campaigns()->count();

        $avgOpenRate = $topic->campaigns()
            ->where('status', 'sent')
            ->get()
            ->avg('open_rate') ?? 0;

        $avgClickRate = $topic->campaigns()
            ->where('status', 'sent')
            ->get()
            ->avg('click_rate') ?? 0;

        return [
            'topic' => $topic,
            'total_subscribers' => $totalSubscribers,
            'active_subscribers' => $activeSubscribers,
            'total_campaigns' => $totalCampaigns,
            'avg_open_rate' => round($avgOpenRate, 2),
            'avg_click_rate' => round($avgClickRate, 2),
        ];
    }

    public function getOverallAnalytics(): array
    {
        $totalSubscribers = \App\Models\Subscriber::count();
        $activeSubscribers = \App\Models\Subscriber::active()->count();
        $pendingSubscribers = \App\Models\Subscriber::where('status', 'pending')->count();
        $unsubscribed = \App\Models\Subscriber::where('status', 'unsubscribed')->count();

        $totalCampaigns = EmailCampaign::count();
        $sentCampaigns = EmailCampaign::where('status', 'sent')->count();

        $totalEmailsSent = EmailLog::where('status', 'sent')->count();
        $totalOpens = EmailLog::whereNotNull('opened_at')->count();
        $totalClicks = EmailLog::where('click_count', '>', 0)->count();

        return [
            'subscribers' => [
                'total' => $totalSubscribers,
                'active' => $activeSubscribers,
                'pending' => $pendingSubscribers,
                'unsubscribed' => $unsubscribed,
            ],
            'campaigns' => [
                'total' => $totalCampaigns,
                'sent' => $sentCampaigns,
            ],
            'emails' => [
                'total_sent' => $totalEmailsSent,
                'total_opens' => $totalOpens,
                'total_clicks' => $totalClicks,
                'open_rate' => $totalEmailsSent > 0 ? round(($totalOpens / $totalEmailsSent) * 100, 2) : 0,
                'click_rate' => $totalEmailsSent > 0 ? round(($totalClicks / $totalEmailsSent) * 100, 2) : 0,
            ],
        ];
    }
}
