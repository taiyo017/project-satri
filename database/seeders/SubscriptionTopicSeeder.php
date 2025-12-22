<?php

namespace Database\Seeders;

use App\Models\SubscriptionTopic;
use Illuminate\Database\Seeder;

class SubscriptionTopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            [
                'name' => 'Job Postings',
                'slug' => 'job-postings',
                'description' => 'Get notified about new job opportunities and career openings.',
                'is_active' => true,
            ],
            [
                'name' => 'Course Launches',
                'slug' => 'course-launches',
                'description' => 'Be the first to know about new courses and training programs.',
                'is_active' => true,
            ],
            [
                'name' => 'Company Announcements',
                'slug' => 'announcements',
                'description' => 'Stay updated with important company news and announcements.',
                'is_active' => true,
            ],
            [
                'name' => 'Newsletter',
                'slug' => 'newsletter',
                'description' => 'Receive our monthly newsletter with insights and updates.',
                'is_active' => true,
            ],
        ];

        foreach ($topics as $topic) {
            SubscriptionTopic::firstOrCreate(
                ['slug' => $topic['slug']],
                $topic
            );
        }
    }
}
