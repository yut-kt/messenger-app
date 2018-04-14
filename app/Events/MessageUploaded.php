<?php

namespace App\Events;

use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Symfony\Component\EventDispatcher\Event;


class MessageUploaded extends Event implements ShouldBroadcast
{
//    use Dispatchable, InteractsWithSockets, SerializesModels;
    use SerializesModels;

    public $room_id;
    public $user_id;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->room_id = $message->room_id;
        $this->user_id = $message->user_id;
        $this->message = $message->message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
//        return new PrivateChannel('channel-name');
        return ['messageAction'];
    }
}
