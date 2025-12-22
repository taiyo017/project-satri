<?php

namespace App\Listeners;

use App\Events\CourseLaunched;
use App\Models\SubscriptionTopic;
use App\Services\EmailNotificationService;

class NotifyCourseSubscribers
{
    public function __construct(
        private EmailNotificationService $notificationService
    ) {}

    public function handle(CourseLaunched $event): void
    {
        $topic = SubscriptionTopic::where('slug', 'course-launches')
            ->where('is_active', true)
            ->first();

        if (!$topic) {
            return;
        }

        $content = view('emails.notifications.course-launched', [
            'course' => $event->course
        ])->render();

        $this->notificationService->sendContentNotification(
            $topic,
            'New Course Available: ' . $event->course->title,
            $content,
            route('course.show', $event->course->slug),
            ['course_id' => $event->course->id]
        );
    }
}
