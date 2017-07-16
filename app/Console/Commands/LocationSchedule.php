<?php

namespace App\Console\Commands;

use App\location;
use App\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class LocationSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location_schedule {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gameboard status Update';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now(Config::get('app.timezone'));
        $location_id = $this->argument('location');
        //Log::info('--- Starting location'.$location_id .' time:'. $now . ' ---');
        //sleep(10);

        $location = Location::findorfail($location_id);

        //Check status of gameboards
        if (!isset($location)) {
            Log::error('Error location:' . $location_id . ' doesnt exist!');
            return;
        }

        foreach($location->gameboards as $gameboard)
        {
            $start = Carbon::parse($gameboard->startgame); //en UTC
            $end = Carbon::parse($gameboard->endgame);

            $newstatus = $gameboard->status;

            if ($now >= $start && $now <= $end && $gameboard->status == Status::DISABLED){
                $newstatus = Status::SCHEDULED;
            }
            elseif ($now >= $start  && $now <= $end && $gameboard->status >= Status::SCHEDULED && $gameboard->getHasResults()){
                $newstatus = Status::RUNNING;
            }
            elseif ($now > $end && $gameboard->status > Status::SCHEDULED){
                $newstatus = Status::FINISHED;
            }


            // Si hay algún cambio se guarda en BBDD y se envia a pantalla
            if ($newstatus != $gameboard->status) {
                //Log::info('Gameboard :'.$gameboard->name. ' GAME_ID:'.$gameboard->id);
                //Log::info('Status change from ' . $gameboard->status . ' to ' . $newstatus);

                $gameboard->status = $newstatus;

                if ($gameboard->activity->type == 'bet' && $newstatus == Status::FINISHED)
                    $gameboard->calculateRankings();
                $gameboard->save();
                $gameboard->updateGameView();
            }


            // END GAME
            $later = $end->addMinutes(60);
            if ($now > $later) {
                $location->country->calculateRankings();
                // Se limpian los valores de los participantes en el juego...OJO en el futuro habrá que almacenarlos
                // en algun histórico para BIG DATA. En este paso los puntos se acumulan en su profile.
                $gameboard->destroyGame();
            }


        }

    }


}
