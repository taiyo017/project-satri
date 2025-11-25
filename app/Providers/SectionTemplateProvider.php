<?php

namespace App\Providers;

use App\Services\SectionTemplateService;
use Illuminate\Support\ServiceProvider;

class SectionTemplateServices extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SectionTemplateService::class, function ($app) {
            return new SectionTemplateService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
