<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;



class MessageEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $message;
    public $channel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,$channel)
    {
        $this->message = $message;
        $this->channel = $channel;
    }




    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [$this->channel];
    }
}
