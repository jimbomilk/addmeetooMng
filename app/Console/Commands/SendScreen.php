<?php

namespace App\Console\Commands;

use App\Adspack;
use App\Advertisement;
use App\Events\Envelope;
use App\Gameboard;
use App\Jobs\AdsEngine;
use App\Jobs\GameEngine;
use App\Jobs\MsgEngine;
use App\location;
use App\Message;
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
        $delay_inicial=$location->screen_timer;
        Log::info('Location:'.$location);

        //Recoger las categorias que admite el local y crear query para
        //filtra los ads : la query debe tener en cuanta las preferencias del local y su geolocalizacion

        if (isset($location)) {
            // En 10 minutos hay que meter 30 anuncios y 30 pantallas
            $delay = $delay_inicial;
            while ( $delay < 600 ) {
                Log::info('Delay:'.$delay);

                if($this->screenAds($location->id,$delay))
                    $delay += $delay_inicial;

                if($this->screenAgenda($location->id,$delay))
                    $delay += $delay_inicial;

                $nScreens = $this->screenGame($location->id,$delay,$delay_inicial);
                $delay = $delay + ($nScreens*$delay_inicial);

            }
        }

    }



    public function screenAds( $location_id,$delay)
    {
        Log::info('*** REQUEST ADS, LOCATION: ' . $location_id . ' DELAY:'.$delay );
        $adsPack = Adspack::where('bigpack','>=',0)->inRandomOrder()->first();

        // recogemos el ads
        if (!isset($adsPack))
            return false;

        $ads = Advertisement::find($adsPack ->advertisement_id);
        if (isset($ads)) {
            //2 se lo enviamos a la cola de procesado

            $message = new Envelope();
            $message->ltext    = $ads->textbig1;
            $message->stext    = $ads->textbig2;
            $message->image    = $ads->imagebig;
            $message->type     = 'bigpack';
            $job = (new AdsEngine($message, $location_id))
                ->delay($delay)
                ->onQueue('bigpack');

            $this->dispatch($job);

            // REVISAR : De momento lo dejamos AQUI pero debería ser descontado al recibir la confirmación de la
            // pantalla.
            $adspack->bigdisplayed++;
            $adspack->save();
            return true;
        }
        return false;
    }


    public function screenGame($location_id,$delay,$delay_inicial)
    {
        $now = Carbon::now(Config::get('app.timezone'));
        $nscreens=0;
        $d = $delay;
        foreach (Gameboard::where('location_id', '=', $location_id)
                     ->where('status', '>', Status::SCHEDULED)
                     ->where('status' , '<=', Status::OFFICIAL)
                     ->cursor() as $gameboard)
        {
            $gameview = $gameboard->getGameView($gameboard->status);
            if(isset($gameview)) {
                //Log::info('Delay GAME:'.$d);
                $job = (new GameEngine($gameview, $location_id))
                    ->delay($d)
                    ->onQueue('bigpack');
                $this->dispatch($job);
                $nscreens ++;
                $d = $d + $delay_inicial;
            }
        }

        return $nscreens;


    }

    public function screenAgenda($location_id,$delay)
    {
        $now = Carbon::now(Config::get('app.timezone'))->toDateTimeString();

        $message = Message::where('location_id', '=', $location_id)
            ->where('type','<>','util')
            ->where('start','<=',$now)
            ->where('end'  ,'>', $now)
            ->inRandomOrder()->first();

        if(isset($message)){
            $envelope = new Envelope();
            $envelope->stext = $message->stext;
            $envelope->ltext = $message->ltext;
            $envelope->image = $message->image;
            $envelope->type = 'info';
            $envelope->logo1 = isset($message->location)?$message->location->logo:"";
            $job = (new AdsEngine($envelope, $location_id))
                    ->delay($delay)
                    ->onQueue('bigpack');
            $this->dispatch($job);
            return true;
        }
        return false;
    }


}
