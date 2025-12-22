<?php

namespace App\Listeners;

use App\Events\ContentPublished;
use App\Models\SubscriptionTopic;
use App\Services\EmailNotificationService;

class NotifySubscribers
{
    public function __construct(
        private EmailNotificationService $notificationService
    ) {}

    public function handle(ContentPublished $event): void
    {
        $topic = SubscriptionTopic::where('slug', $event->topicSlug)
            ->where('is_active', true)
            ->first();

        if (!$topic) {
            return;
        }

        $this->notificationService->sendContentNotification(
            $topic,
            $event->title,
            $event->content,
            $event->url,
            $event->metadata
        );
    }
}
