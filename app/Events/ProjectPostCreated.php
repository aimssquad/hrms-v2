<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectPostCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        // Sent to React / Flutter
        $this->data = $data;
    }

    public function broadcastOn()
    {
        // Project based group channel
        return new Channel(
            "project-channel.{$this->data['emid']}.{$this->data['project_id']}"
        );
    }

    public function broadcastAs()
    {
        return 'project-post-live';
    }
}
