<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_log_id')->constrained()->onDelete('cascade');
            $table->text('url');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('clicked_at');
            $table->timestamps();
            
            $table->index('email_log_id');
            $table->index('clicked_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_clicks');
    }
};
