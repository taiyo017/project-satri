<?php

namespace App\Providers;

use App\Events\ContentPublished;
use App\Events\CourseLaunched;
use App\Events\JobPosted;
use App\Listeners\NotifySubscribers;
use App\Listeners\NotifyCourseSubscribers;
use App\Listeners\NotifyJobSubscribers;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register event listeners for email subscription system
        Event::listen(ContentPublished::class, NotifySubscribers::class);
        Event::listen(CourseLaunched::class, NotifyCourseSubscribers::class);
        Event::listen(JobPosted::class, NotifyJobSubscribers::class);
    }
}
