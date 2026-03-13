<?php

namespace App\Events;

use App\Models\NewMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    public function __construct(NewMessage $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        if ($this->message->group_id) {
            return new PrivateChannel('group.' . $this->message->group_id);
        }

        return new PrivateChannel('chat.' . $this->message->receiver_id);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'type' => $this->message->type,
            'message' => $this->message->message,
            'file_path' => $this->message->file_path,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}