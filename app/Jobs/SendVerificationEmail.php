<?php

namespace App\Jobs;

use App\Mail\SubscriptionVerification;
use App\Models\EmailLog;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 300, 900];

    public function __construct(
        public Subscriber $subscriber,
        public array $topics
    ) {}

    public function handle(): void
    {
        $emailLog = EmailLog::create([
            'subscriber_id' => $this->subscriber->id,
            'subject' => 'Verify Your Email Subscription',
            'type' => 'verification',
            'status' => 'queued',
        ]);

        try {
            Mail::to($this->subscriber->email)
                ->send(new SubscriptionVerification($this->subscriber, $this->topics));

            $emailLog->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            $emailLog->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
