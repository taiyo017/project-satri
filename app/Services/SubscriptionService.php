<?php

namespace App\Services;

use App\Jobs\SendVerificationEmail;
use App\Models\Subscriber;
use App\Models\SubscriptionTopic;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function subscribe(
        string $email,
        array $topicIds,
        ?string $name = null,
        ?string $ip = null,
        ?string $userAgent = null
    ): Subscriber {
        return DB::transaction(function () use ($email, $topicIds, $name, $ip, $userAgent) {
            $subscriber = Subscriber::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'status' => 'pending',
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                ]
            );

            // If already verified and unsubscribed, reactivate
            if ($subscriber->isVerified() && $subscriber->status === 'unsubscribed') {
                $subscriber->update(['status' => 'active']);
            }

            // Attach topics
            $topicsToAttach = [];
            foreach ($topicIds as $topicId) {
                $topicsToAttach[$topicId] = ['subscribed_at' => now()];
            }

            $subscriber->topics()->syncWithoutDetaching($topicsToAttach);

            // Send verification email if not verified
            if (!$subscriber->isVerified()) {
                $topics = SubscriptionTopic::whereIn('id', $topicIds)->get();

                // Dispatch immediately without queue for testing
                try {
                    SendVerificationEmail::dispatchSync($subscriber, $topics->toArray());
                } catch (\Exception $e) {
                    SendVerificationEmail::dispatch($subscriber, $topics->toArray())
                        ->onQueue('emails');
                }
            }

            return $subscriber->fresh();
        });
    }

    public function verify(string $token): ?Subscriber
    {
        $subscriber = Subscriber::where('verification_token', $token)->first();

        if (!$subscriber || $subscriber->isVerified()) {
            return null;
        }

        $subscriber->verify();

        return $subscriber;
    }

    public function unsubscribe(string $token): ?Subscriber
    {
        $subscriber = Subscriber::where('unsubscribe_token', $token)->first();

        if (!$subscriber) {
            return null;
        }

        $subscriber->unsubscribe();

        return $subscriber;
    }

    public function updatePreferences(Subscriber $subscriber, array $topicIds): void
    {
        $topicsToSync = [];
        foreach ($topicIds as $topicId) {
            $topicsToSync[$topicId] = ['subscribed_at' => now()];
        }

        $subscriber->topics()->sync($topicsToSync);
    }
}