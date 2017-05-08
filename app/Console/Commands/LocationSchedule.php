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
        Log::info('--- Starting location'.$location_id .' time:'. $now . ' ---');
        //sleep(10);

        $location = Location::findorfail($location_id);

        //Check status of gameboards
        if (!isset($location)) {
            Log::error('Error location:' . $location_id . ' doesnt exist!');
            return;
        }

        foreach($location->gameboards as $gameboard)
        {
            $start = Carbon::parse($gameboard->starttime); //en UTC
            $end = Carbon::parse($gameboard->starttime)->addMinutes($gameboard->duration);

            $newstatus = $gameboard->status;

            if ($now >= $start && $now <= $end && $gameboard->status == Status::SCHEDULED) {
                $newstatus = Status::STARTLIST;
            }elseif ($now >= $start && $now <= $end && $gameboard->status == Status::STARTLIST){
                $newstatus = Status::RUNNING;
            }


            // Si se acabo su tiempo lo terminamos
            if ($now >= $end && $gameboard->status > Status::SCHEDULED){
                $newstatus = Status::FINISHED;
            }

            // Si encima hemos recibido ya los resultados o se trata de una votación
            if ($now >= $end && ($gameboard->getHasResults() || $gameboard->activity->type == 'vote') ){
                $newstatus = Status::OFFICIAL;
                if ($gameboard->activity->type == 'bet')
                    $gameboard->calculateRankings();
            }


            // Si hay algún cambio se guarda en BBDD y se envia a pantalla
            if ($newstatus != $gameboard->status) {
                Log::info('Gameboard :'.$gameboard->name. ' GAME_ID:'.$gameboard->id);
                Log::info('Starting time :'.$gameboard->starttime);
                Log::info('Status change from ' . $gameboard->status . ' to ' . $newstatus);

                $gameboard->status = $newstatus;
                $gameboard->save();
                $gameboard->updateGameView();

            }



            //DAILY RESET GAMES
            $later = $end->addMinutes(60);

            if ($gameboard->status > Status::SCHEDULED && $now >$later) {

                $gameboard->status = Status::DISABLED;
                $location->country->calculateRankings();
            }

            // END GAME
            $endGame = Carbon::parse($gameboard->endGame); //en UTC
            if ($now > $endGame) {
                $location->country->calculateRankings();
                // Se limpian los valores de los participantes en el juego...OJO en el futuro habrá que almacenarlos
                // en algun histórico para BIG DATA. En este paso los puntos se acumulan en su profile.
                $gameboard->destroyGame();
            }


        }

    }


}
