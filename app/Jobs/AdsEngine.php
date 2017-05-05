<?php

namespace App\Jobs;

use App\Advertisement;
use App\Events\AdsEvent;
use App\Events\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AdsEngine extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $ads;
    protected $location;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Advertisement $ads,$location,$type)
    {
        $this->ads = $ads;
        $this->location = $location;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $message = new Envelope();
        $message->ltext    = $this->ads->textsmall1;
        $message->stext    = $this->ads->textsmall2;
        $message->image    = $this->ads->imagesmall;
        $message->type     = $this->type;

        Log::info('Job running, ADS'.$this->ads->textsmall1. ', LOCATION : '.$this->location);

        // A pantalla
        event(new AdsEvent($message, 'location'. $this->location));
    }
}
