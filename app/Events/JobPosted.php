<?php

namespace App\Events;

use App\Models\Career;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Career $career) {}
}
