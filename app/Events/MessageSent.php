<?php

namespace Fickrr\Events;

use Fickrr\Models\Message;
use Fickrr\Models\NotificationSetting;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load(['sender', 'receiver']);
    }

    public function broadcastOn()
    {
        $receiverSettings = NotificationSetting::getSettings($this->message->receiver_id);
        
        if ($receiverSettings->messages) {
            return new PrivateChannel('chat.'.$this->message->receiver_id);
        }
        
        return [];
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}