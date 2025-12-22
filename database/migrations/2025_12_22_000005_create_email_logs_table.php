<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained()->onDelete('cascade');
            $table->foreignId('email_campaign_id')->nullable()->constrained()->onDelete('set null');
            $table->string('subject');
            $table->enum('type', ['verification', 'campaign', 'notification', 'system']);
            $table->enum('status', ['queued', 'sent', 'failed', 'bounced'])->default('queued');
            $table->string('tracking_token')->unique();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->integer('open_count')->default(0);
            $table->integer('click_count')->default(0);
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index('tracking_token');
            $table->index(['subscriber_id', 'type']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
