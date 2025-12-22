<?php

namespace App\Console\Commands;

use App\Models\Subscriber;
use App\Models\EmailLog;
use App\Models\SubscriptionTopic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckEmailSystem extends Command
{
    protected $signature = 'email:check';
    protected $description = 'Check email subscription system status';

    public function handle(): int
    {
        $this->info('===========================================');
        $this->info('Email Subscription System Status Check');
        $this->info('===========================================');
        $this->newLine();

        // Check Email Configuration
        $this->info('📧 Email Configuration:');
        $this->line('  Mailer: ' . config('mail.default'));
        $this->line('  Host: ' . config('mail.mailers.smtp.host'));
        $this->line('  Port: ' . config('mail.mailers.smtp.port'));
        $this->line('  From: ' . config('mail.from.address'));
        $this->newLine();

        // Check Queue Configuration
        $this->info('⚙️  Queue Configuration:');
        $this->line('  Connection: ' . config('queue.default'));
        $this->newLine();

        // Check Database Tables
        $this->info('🗄️  Database Status:');
        try {
            $subscribersCount = Subscriber::count();
            $topicsCount = SubscriptionTopic::count();
            $emailLogsCount = EmailLog::count();
            
            $this->line('  ✅ Subscribers: ' . $subscribersCount);
            $this->line('  ✅ Topics: ' . $topicsCount);
            $this->line('  ✅ Email Logs: ' . $emailLogsCount);
        } catch (\Exception $e) {
            $this->error('  ❌ Database Error: ' . $e->getMessage());
        }
        $this->newLine();

        // Check Queue Jobs
        $this->info('📋 Queue Status:');
        try {
            $pendingJobs = DB::table('jobs')->count();
            $failedJobs = DB::table('failed_jobs')->count();
            
            $this->line('  Pending Jobs: ' . $pendingJobs);
            $this->line('  Failed Jobs: ' . $failedJobs);
            
            if ($failedJobs > 0) {
                $this->warn('  ⚠️  You have failed jobs! Run: php artisan queue:retry all');
            }
        } catch (\Exception $e) {
            $this->error('  ❌ Queue Error: ' . $e->getMessage());
        }
        $this->newLine();

        // Check Recent Subscribers
        $this->info('👥 Recent Subscribers:');
        try {
            $recentSubscribers = Subscriber::latest()->take(5)->get();
            
            if ($recentSubscribers->isEmpty()) {
                $this->line('  No subscribers yet');
            } else {
                foreach ($recentSubscribers as $subscriber) {
                    $status = $subscriber->status;
                    $verified = $subscriber->verified_at ? '✅' : '⏳';
                    $this->line("  {$verified} {$subscriber->email} ({$status})");
                }
            }
        } catch (\Exception $e) {
            $this->error('  ❌ Error: ' . $e->getMessage());
        }
        $this->newLine();

        // Check Recent Email Logs
        $this->info('📨 Recent Email Logs:');
        try {
            $recentLogs = EmailLog::latest()->take(5)->get();
            
            if ($recentLogs->isEmpty()) {
                $this->line('  No email logs yet');
            } else {
                foreach ($recentLogs as $log) {
                    $statusIcon = $log->status === 'sent' ? '✅' : ($log->status === 'failed' ? '❌' : '⏳');
                    $this->line("  {$statusIcon} {$log->subject} ({$log->status})");
                }
            }
        } catch (\Exception $e) {
            $this->error('  ❌ Error: ' . $e->getMessage());
        }
        $this->newLine();

        // Recommendations
        $this->info('💡 Recommendations:');
        
        if (config('mail.default') === 'log') {
            $this->warn('  ⚠️  Mail driver is set to "log" - emails will be logged to storage/logs/laravel.log');
            $this->line('     For testing, consider using MailHog or Mailtrap');
        }
        
        if (config('queue.default') === 'sync') {
            $this->warn('  ⚠️  Queue is set to "sync" - emails will be sent immediately');
            $this->line('     For better performance, use "database" queue and run queue worker');
        }
        
        if (config('queue.default') === 'database') {
            $this->info('  ✅ Queue is configured correctly');
            $this->line('     Make sure queue worker is running: php artisan queue:work --queue=emails');
        }
        
        $this->newLine();
        $this->info('===========================================');
        $this->info('Check complete!');
        $this->info('===========================================');

        return self::SUCCESS;
    }
}
