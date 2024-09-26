<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public string $message;
    public function __construct($message)
    {
        $this->message = $message->message;
    }

    public function broadcastOn()
    {
        return ['public'];
    }
    public function broadcastWith()
    {
        return ['message' => $this->message]; // Sending the message content
    }

    public function broadcastAs()
    {
        return 'chat';
    }
}
