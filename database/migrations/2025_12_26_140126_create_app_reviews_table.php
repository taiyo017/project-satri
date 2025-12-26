<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_id')->constrained('apps')->onDelete('cascade');
            $table->string('reviewer_name');
            $table->string('reviewer_email');
            $table->tinyInteger('rating')->unsigned()->comment('1-5 stars');
            $table->text('review');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->index(['app_id', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_reviews');
    }
};
