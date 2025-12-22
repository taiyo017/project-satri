<?php

namespace App\Jobs;

use App\Mail\CampaignEmail;
use App\Models\EmailCampaign;
use App\Models\EmailLog;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCampaignEmailFromCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 300, 900];

    public function __construct(
        public Subscriber $subscriber,
        public EmailCampaign $campaign,
        public EmailLog $emailLog
    ) {}

    public function handle(): void
    {
        try {
            Mail::to($this->subscriber->email)
                ->send(new CampaignEmail(
                    $this->subscriber,
                    $this->campaign,
                    $this->emailLog
                ));

            $this->emailLog->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            $this->campaign->increment('sent_count');
        } catch (\Exception $e) {
            $this->emailLog->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            $this->campaign->increment('failed_count');

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        $this->campaign->increment('failed_count');
    }
}
