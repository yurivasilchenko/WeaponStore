<?php

namespace App\Events;

use App\Models\User;
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
    public int $recipient_id;
    public int $sender_id;
    private User $user;

    public function __construct($data)
    {
        $this->message = $data['message'];
        $this->recipient_id = $data['recipient_id'];
        $this->sender_id = auth()->id(); // Set the sender_id to the authenticated user's ID

    }

    public function broadcastOn()
    {
        if (auth()->user()->isAdmin()) {
            // Admin sends message to the recipient's channel
            return new PrivateChannel('chat.' . $this->recipient_id);
        } else {
            // Regular user sends message to their own channel
            return new PrivateChannel('chat.' . $this->sender_id);
        }
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'sender_id' => $this->sender_id,
            'recipient_id' => $this->recipient_id,
        ];
    }

    public function broadcastAs()
    {
        return 'chat';
    }

}
