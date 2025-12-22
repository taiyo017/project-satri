<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriber_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_topic_id')->constrained()->onDelete('cascade');
            $table->timestamp('subscribed_at');
            $table->timestamps();
            
            $table->unique(['subscriber_id', 'subscription_topic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriber_topics');
    }
};
