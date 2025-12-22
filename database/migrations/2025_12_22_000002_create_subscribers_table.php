<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('verification_token')->unique();
            $table->timestamp('verified_at')->nullable();
            $table->enum('status', ['pending', 'active', 'unsubscribed', 'bounced'])->default('pending');
            $table->string('unsubscribe_token')->unique();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('email');
            $table->index('status');
            $table->index('verified_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
