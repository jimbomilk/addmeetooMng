<?php

namespace App\Console\Commands;

use App\Adspack;
use App\Advertisement;
use App\Events\Envelope;
use App\Jobs\AdsEngine;
use App\Jobs\MsgEngine;
use App\location;
use App\Message;
use App\UserGameboard;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendMessage extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Messages burner';

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
        Log::info('Location:'.$location);

        //Recoger las categorias que admite el local y crear query para
        //filtra los ads : la query debe tener en cuanta las preferencias del local y su geolocalizacion

        if (isset($location)) {
            // En 10 minutos hay que meter n anuncios
            $nScreens = 0;
            $delay = 0;
            $alternate = true;
            while ( $delay < 600 ) {

                Log::info('Delay smallADS:'.$delay);

                if($alternate)
                    $this->screenAds($location->id,$delay);
                else
                    $this->screenMsg($location->id,$delay);

                $alternate = !$alternate;

                $delay = $delay + 10; // Los mensajes duran 5 segundos

            }
        }

    }

    public function screenMsg($location_id, $delay)
    {
        //$usergame = UserGameboard::where('location','=',$location_id)->inRandomOrder()->first();

        $usergame = DB::table('user_gameboards')
            ->join('gameboards',function($join) {
                global $location_id;
                $join->on('user_gameboards.gameboard_id', '=', 'gameboards.id')
                    ->where ('gameboards.location_id','=',$location_id);
            })
            ->inRandomOrder()->first();

        if (!isset($usergame))
            return false;

        $msg = new Envelope();
        $user = $usergame->user;
        $msg->stext = strtoupper($user->name);
        $msg->ltext = $usergame->gameboard->name;
        $msg->image = $user->avatar;
        $msg->type = 'message';

        $job = (new MsgEngine($msg, $location_id))
            ->delay($delay)
            ->onQueue('smallpack');

        $this->dispatch($job);
    }

    public function screenAds($location_id,$delay)
    {
        //Log::info('*** REQUEST ADS: ' . $advertisement_id . ' DELAY:'.$delay );
        $adsPack = Adspack::where('smallpack','>',0)->inRandomOrder()->first();

        Log::info('screenADS entrando');
        // recogemos el ads
        if (!isset($adsPack))
            return false;


        //2 se lo enviamos a la cola de procesado
        $job = (new AdsEngine($adsPack->advertisement, $location_id,'smallpack'))
            ->delay($delay)
            ->onQueue('smallpack');

        $this->dispatch($job);

        // REVISAR : De momento lo dejamos AQUI pero debería ser descontado al recibir la confirmación de la
        // pantalla.
        $adsPack->smalldisplayed++;

        $adsPack->save();
        return true;


    }



}
