<?php

namespace App\Listeners;

use App\Events\JobPosted;
use App\Models\SubscriptionTopic;
use App\Services\EmailNotificationService;

class NotifyJobSubscribers
{
    public function __construct(
        private EmailNotificationService $notificationService
    ) {}

    public function handle(JobPosted $event): void
    {
        $topic = SubscriptionTopic::where('slug', 'job-postings')
            ->where('is_active', true)
            ->first();

        if (!$topic) {
            return;
        }

        $content = view('emails.notifications.job-posted', [
            'job' => $event->career
        ])->render();

        $this->notificationService->sendContentNotification(
            $topic,
            'New Job Opening: ' . $event->career->title,
            $content,
            route('career.show', $event->career->slug),
            ['job_id' => $event->career->id]
        );
    }
}
