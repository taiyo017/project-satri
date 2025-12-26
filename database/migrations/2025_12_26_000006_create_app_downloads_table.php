<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_id')->constrained('apps')->cascadeOnDelete();
            $table->foreignId('app_version_id')->nullable()->constrained('app_versions')->nullOnDelete();
            $table->enum('platform', ['android', 'ios', 'web', 'desktop', 'unknown']);
            $table->enum('source', ['direct', 'qr_code', 'redirect', 'web']);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('country_name')->nullable();
            $table->string('city')->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamps();
            
            $table->index(['app_id', 'created_at']);
            $table->index(['platform', 'created_at']);
            $table->index('country_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_downloads');
    }
};
