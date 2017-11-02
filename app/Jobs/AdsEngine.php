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

    public $duration;
    protected $msg;
    protected $location;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Envelope $msg,$location)
    {
        $this->duration = 0;
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
        //Log::info('Job running, ADS'.$this->ads->textsmall1. ', LOCATION : '.$this->location);

        // A pantalla
        event(new AdsEvent($this->msg, 'location'. $this->location));
    }
}
