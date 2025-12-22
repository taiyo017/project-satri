<?php

namespace App\Jobs;

use App\Mail\ContentNotification;
use App\Models\EmailLog;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCampaignEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 300, 900];

    public function __construct(
        public Subscriber $subscriber,
        public string $subject,
        public string $content,
        public ?string $url,
        public EmailLog $emailLog
    ) {}

    public function handle(): void
    {
        try {
            Mail::to($this->subscriber->email)
                ->send(new ContentNotification(
                    $this->subscriber,
                    $this->subject,
                    $this->content,
                    $this->url,
                    $this->emailLog
                ));

            $this->emailLog->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            $this->emailLog->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
