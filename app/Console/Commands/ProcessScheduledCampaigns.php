<?php

namespace App\Console\Commands;

use App\Models\EmailCampaign;
use App\Services\EmailNotificationService;
use Illuminate\Console\Command;

class ProcessScheduledCampaigns extends Command
{
    protected $signature = 'campaigns:process-scheduled';
    protected $description = 'Process and send scheduled email campaigns';

    public function __construct(
        private EmailNotificationService $notificationService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $campaigns = EmailCampaign::scheduled()->get();

        if ($campaigns->isEmpty()) {
            $this->info('No scheduled campaigns to process.');
            return self::SUCCESS;
        }

        foreach ($campaigns as $campaign) {
            $this->info("Processing campaign: {$campaign->subject}");
            
            try {
                $this->notificationService->sendCampaignToTopic($campaign->id);
                $this->info("Campaign queued successfully.");
            } catch (\Exception $e) {
                $this->error("Failed to process campaign: {$e->getMessage()}");
                $campaign->update(['status' => 'failed']);
            }
        }

        $this->info("Processed {$campaigns->count()} campaign(s).");
        return self::SUCCESS;
    }
}
