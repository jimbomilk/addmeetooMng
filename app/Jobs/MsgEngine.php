<?php

namespace App\Jobs;

use App\Events\MessageEvent;
use App\Events\Envelope;
use App\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class MsgEngine extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $msg;
    protected $location;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Envelope $msg,$location)
    {
        $this->msg = $msg;
        $this->location = $location;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // A pantalla
        event(new MessageEvent($this->msg, 'location'. $this->location));
    }
}
