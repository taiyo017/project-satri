<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_category_id')->nullable()->constrained('app_categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('package_name')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['active', 'inactive', 'draft'])->default('draft');
            $table->integer('download_count')->default(0);
            $table->integer('scan_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};
