<?php

namespace App\Console\Commands;

use App\Models\Subscriber;
use App\Models\SubscriptionTopic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'email:test {email}';
    protected $description = 'Send a test email to verify email configuration';

    public function handle(): int
    {
        $email = $this->argument('email');

        try {
            Mail::raw('This is a test email from your subscription system.', function ($message) use ($email) {
                $message->to($email)
                    ->subject('Test Email - Subscription System');
            });

            $this->info("Test email sent successfully to {$email}");
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to send test email: {$e->getMessage()}");
            return self::FAILURE;
        }
    }
}
