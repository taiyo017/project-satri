<?php

namespace App\Services;

use App\Jobs\SendCampaignEmail;
use App\Models\EmailLog;
use App\Models\Subscriber;
use App\Models\SubscriptionTopic;
use Illuminate\Support\Facades\DB;

class EmailNotificationService
{
    public function sendContentNotification(
        SubscriptionTopic $topic,
        string $subject,
        string $content,
        ?string $url = null,
        array $metadata = []
    ): void {
        $subscribers = $topic->activeSubscribers()->get();

        foreach ($subscribers as $subscriber) {
            $emailLog = EmailLog::create([
                'subscriber_id' => $subscriber->id,
                'subject' => $subject,
                'type' => 'notification',
                'status' => 'queued',
            ]);

            // Use dispatchSync for immediate sending (no queue worker needed)
            SendCampaignEmail::dispatchSync(
                $subscriber,
                $subject,
                $content,
                $url,
                $emailLog
            );
        }
    }

    public function sendCampaignToTopic(int $campaignId): void
    {
        $campaign = \App\Models\EmailCampaign::with('topic')->findOrFail($campaignId);
        
        $campaign->update([
            'status' => 'sending',
        ]);

        $subscribers = $campaign->topic->activeSubscribers()->get();
        $campaign->update(['total_recipients' => $subscribers->count()]);

        foreach ($subscribers as $subscriber) {
            $emailLog = EmailLog::create([
                'subscriber_id' => $subscriber->id,
                'email_campaign_id' => $campaign->id,
                'subject' => $campaign->subject,
                'type' => 'campaign',
                'status' => 'queued',
            ]);

            // Use dispatchSync for immediate sending (no queue worker needed)
            \App\Jobs\SendCampaignEmailFromCampaign::dispatchSync(
                $subscriber,
                $campaign,
                $emailLog
            );
        }
        
        // Mark campaign as sent after all emails are sent
        $campaign->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }
}
