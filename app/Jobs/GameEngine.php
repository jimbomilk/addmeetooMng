<?php

namespace App\Jobs;

use App\Advertisement;
use App\Gameboard;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ScreenEvent;
use Illuminate\Support\Facades\Log;

class GameEngine extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $game;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Gameboard $game)
    {
        $this->game = $game;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Publicamos la pantalla
        $gameview = $this->game->getGameView();
        if (isset($gameview) ) {
            //Log::info('Job running, GAMEID:' . $this->game->id . ' GAMEVIEW : ' . $gameview->id);
            event(new ScreenEvent($gameview, 'location' . $this->game->location_id));
        }
    }
}
