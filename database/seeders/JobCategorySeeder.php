<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Full-time',
                'slug' => 'full-time',
                'description' => 'Full-time permanent positions with complete benefits and job security.',
            ],
            [
                'name' => 'Part-time',
                'slug' => 'part-time',
                'description' => 'Part-time positions with flexible working hours.',
            ],
            [
                'name' => 'Internship',
                'slug' => 'internship',
                'description' => 'Internship opportunities for students and fresh graduates to gain experience.',
            ],
            [
                'name' => 'Contract',
                'slug' => 'contract',
                'description' => 'Contract-based positions for specific projects or time periods.',
            ],
            [
                'name' => 'Remote',
                'slug' => 'remote',
                'description' => 'Work from anywhere positions with full remote flexibility.',
            ],
            [
                'name' => 'Freelance',
                'slug' => 'freelance',
                'description' => 'Freelance opportunities for independent contractors.',
            ],
        ];

        foreach ($categories as $category) {
            JobCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
