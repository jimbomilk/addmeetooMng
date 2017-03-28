<?php

namespace App\Console\Commands;

use App\location;
use App\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LocationUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location_update {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Gameboard update';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now();
        $location_id = $this->argument('location');
        Log::info('--- Starting Daily Update'.$location_id .' time:'. $now . ' ---');
        //sleep(10);

        $location = Location::findorfail($location_id);

        //Check status of gameboards
        if (!isset($location)) {
            Log::error('Error location:' . $location_id . ' doesnt exist!' . ' time: ' . $currentime);
            return;
        }

        foreach($location->gameboards as $gameboard)
        {
            //Gameboard status check
            Log::info('Starting daily update gameboard :'.$gameboard->name);



            if ($gameboard->status == Status::FINISHED && $gameboard->daily) {

                // Se reinicia el status
                $gameboard->status = Status::SCHEDULED;

                // Se limpian los valores de los participantes en el juego...OJO en el futuro habrá que almacenarlos
                // en algun histórico para BIG DATA
                $gameboard->gameboardUsers()->delete();

                $gameboard->save();

                //Si el juego es auto, tendremos que borrar las gameboardoptions y volverlas a crear a partir de las activity options
                if ($gameboard->auto) {
                    $gameboard->gameboardOptions->delete();


                }

                Log::info('Gameboard restarted:'.$gameboard->name);
            }



        }
        Log::info('Ending daily update:'.$location_id);
        Log::info('');
        Log::info('');
        Log::info('');
    }

    private function ranking($gameboard)
    {

    }
}
