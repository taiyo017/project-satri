<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_version_id')->constrained('app_versions')->cascadeOnDelete();
            $table->enum('platform', ['android', 'ios', 'web', 'desktop']);
            $table->enum('file_type', ['apk', 'ipa', 'url', 'bundle']);
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('store_url')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_files');
    }
};
