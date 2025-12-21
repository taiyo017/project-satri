<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->foreignId('job_category_id')->nullable()->after('location')->constrained('job_categories')->onDelete('set null');
            $table->dropColumn('job_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropForeign(['job_category_id']);
            $table->dropColumn('job_category_id');
            $table->enum('job_type', ['full-time', 'part-time', 'internship', 'contract'])->default('full-time');
        });
    }
};
