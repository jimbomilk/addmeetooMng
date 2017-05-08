<?php

namespace App\Jobs;

use App\GameView;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ScreenEvent;
use Illuminate\Support\Facades\Log;

class GameEngine extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $gameview;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GameView $gameview)
    {
        $this->gameview = $gameview;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Publicamos la pantalla
        if (isset($this->gameview) ) {
            //Log::info('Job running, GAMEID:' . $this->game->id . ' GAMEVIEW : ' . $gameview->id);
            event(new ScreenEvent($this->gameview, 'location' . $this->gameview->gameboard->location_id));
        }
    }
}
