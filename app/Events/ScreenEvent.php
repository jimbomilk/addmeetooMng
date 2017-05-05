<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ScreenEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $screen;
    public $channel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($screen,$channel)
    {
        $this->screen = $screen;
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
