<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_id')->constrained('apps')->cascadeOnDelete();
            $table->string('version_number');
            $table->string('version_code')->nullable();
            $table->longText('release_notes')->nullable();
            $table->longText('changelog')->nullable();
            $table->boolean('is_latest')->default(false);
            $table->enum('status', ['active', 'inactive', 'beta'])->default('active');
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_versions');
    }
};
