<?php

namespace App\Console\Commands;

use App\Adspack;
use App\Advertisement;
use App\Gameboard;
use App\Jobs\AdsEngine;
use App\Jobs\GameEngine;
use App\location;
use App\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SendScreen extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'screen {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Skreens burner';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Cada 10 minutos hay que mandar 60 anuncios a cada location. Para ello:
     *
     * 1. Vamos a adspacks y seleccionamos aquellos packs que son compatibles con el local (por posicion y tematica)
     * 2. De todos esos seleccionamos aletoriamente 60 y los metemos en la cola por orden (delay)
     *
     * @return mixed
     */
    public function handle()
    {
        $location_id = $this->argument('location');
        $location = Location::findorfail($location_id);

        //Recoger las categorias que admite el local y crear query para
        //filtra los ads : la query debe tener en cuanta las preferencias del local y su geolocalizacion

        if (isset($location)) {
            // En 10 minutos hay que meter 30 anuncios y 30 pantallas
            $nScreens = 0;
            $delay = 0;
            while ( $delay < 600 ) {

                $delay = $delay + ($nScreens*30); // Las pantallas de actividad duran 30 segundos

                $this->screenAds('bigpack',$location->id,$delay);

                $delay += 10;

                $this->screenAds('smallpack',$location->id,$delay);

                $delay += 10;

                $nScreens = $this->screenGame($location->id,$delay);

            }
        }

    }

    public function screenAds($adstype, $location_id,$delay)
    {
        //Log::info('*** REQUEST ADS: ' . $advertisement_id . ' DELAY:'.$delay );
        $adsPack = Adspack::where($adstype,'>',0)->inRandomOrder()->first();

        // recogemos el ads
        $ads = Advertisement::find($adsPack ->advertisement_id);
        if (isset($ads)) {
            //2 se lo enviamos a la cola de procesado
            $job = (new AdsEngine($ads, $location_id,$adstype))
                ->delay($delay)
                ->onQueue($adstype);

            $this->dispatch($job);

            // REVISAR : De momento lo dejamos AQUI pero debería ser descontado al recibir la confirmación de la
            // pantalla.
            if ($adstype == 'bigpack')
                $adsPack->bigdisplayed++;
            else
                $adsPack->smalldisplayed++;

            $adsPack->save();
        }
    }


    public function screenGame($location_id,$delay)
    {
        $now = Carbon::now(Config::get('app.timezone'));
        $nscreens=0;
        foreach (Gameboard::where('location_id', '=', $location_id)
                     ->where('status', '>=', Status::SCHEDULED)
                     ->where('status' , '<=', Status::OFFICIAL)
                     ->cursor() as $gameboard)
        {
            $start = Carbon::parse($gameboard->startgame);
            $end = Carbon::parse($gameboard->endgame);
            Log::info('*** GAME: '. $gameboard->id. ', NOW:'. $now .' START:' .$start. ', END: ' . $end);

            if ($now >= $start && $now <= $end) {

                $nscreens ++;
                $job = (new GameEngine($gameboard->getGameView($gameboard->status), $location_id))
                    ->delay($delay)
                    ->onQueue('SCREENS');
                $this->dispatch($job);
                $delay = $delay + 15;
                // Pantalla de participación
                $job = (new GameEngine($gameboard->getGameView(Status::STARTLIST), $location_id))
                    ->delay($delay)
                    ->onQueue('SCREENS');
                $this->dispatch($job);
                $delay = $delay + 15;

            }
        }

        return $nscreens;


    }


}
