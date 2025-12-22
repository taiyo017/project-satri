<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContentPublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $topicSlug,
        public string $title,
        public string $content,
        public ?string $url = null,
        public array $metadata = []
    ) {}
}
