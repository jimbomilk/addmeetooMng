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
use Illuminate\Support\Facades\DB;
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
        $location = Location::find($location_id);
        $total_time = 200;

        //Log::info('Location:'.$location);

        if (isset($location)) {
            $delay_screen=$location->screen_timer;
             // Tiempo que tiene cada sección (anuncios, info y actividades)
            $nScreens = round($total_time/$delay_screen);

            $agenda = $this->screenAgenda($location->id,$nScreens);
            $nAgenda = count($agenda);
            // Si no hay agenda los slots se reparten entre las otras dos opciones
            if ($nAgenda< $nScreens)
            {
                $nScreens = round(($nScreens + ($nScreens-$nAgenda))/2);
            }

            $games = $this->screenGame($location->id,$nScreens);
            $nGames = count($games);
            // Si no hay games los slots se dejan unicamente para anuncios
            if ($nGames< $nScreens)
            {
                $nScreens = $nScreens + ($nScreens-$nGames);
            }

            $anuncios = $this->screenAds($location->id,$nScreens);

            $jobs = array_merge($anuncios,$agenda,$games);
            shuffle($jobs);

            $delay = 0;
            foreach($jobs as $job) {
                $job->delay($delay);
                $job->onQueue('bigpack');
                $delay = $delay + $delay_screen;
                $this->dispatch($job);
            }
        }

    }



    public function screenAds( $location_id,$nScreens)
    {
        $a = array();
        $query = "select textbig1,textbig2,imagebig,adspacks.id as packid from adspacks".
                    " inner join advertisements on adspacks.advertisement_id=advertisements.id".
                    " where adspacks.bigpack > 0 and advertisements.location_id=".$location_id.
                    " order by adspacks.bigdisplayed"   ;

        $adsPacks = DB::select(DB::raw($query));
        if (!isset($adsPacks))
            return false;

        $i=0;
        while ($i<$nScreens){
            $previ = $i; // para romper bucles infinitos
            foreach($adsPacks as $adspack) {
                $message = new Envelope();
                $message->ltext = $adspack->textbig1;
                $message->stext = $adspack->textbig2;
                $message->image = $adspack->imagebig;
                $message->type = 'bigpack';

                // actualizar sus visualizaciones
                $pack = Adspack::find($adspack->packid);
                if (isset($pack)) {
                    $pack->bigdisplayed++;
                    $pack->save();
                }

                // creamos el job

                $job = (new AdsEngine($message, $location_id));

                $i++;
                $a[] = $job;
                if ($i == $nScreens) // si ya hemos cumplido salimos.
                    return $a;
            }
            if ($previ == $i)// si en una iteración el valor de i es igual al inicial rompemos el bucle.
                return $a;

        }


        return $a;

    }


    public function screenGame($location_id,$nscreens)
    {
        $i=0;
        $a = array();
        while ($i<$nscreens) {
            $previ = $i;
            foreach (Gameboard::where('location_id', '=', $location_id)
                         ->where('status', '>', Status::SCHEDULED)
                         ->where('status', '<=', Status::OFFICIAL)
                         ->cursor() as $gameboard) {
                $i++;
                $gameview = $gameboard->getGameView($gameboard->status);
                if (isset($gameview)) {
                    //Log::info('Delay GAME:'.$d);
                    $job = (new GameEngine($gameview, $location_id));
                    $a[] = $job;
                    if ($i == $nscreens)
                        return $a;
                }
            }
            if ($previ == $i)// si en una iteración el valor de i es igual al inicial rompemos el bucle.
                return $a;

        }

        return $a;
    }

    public function screenAgenda($location_id,$nscreens)
    {
        $i=0;
        $a = array();
        $now = Carbon::now(Config::get('app.timezone'))->toDateTimeString();

        $messages = Message::where('location_id', '=', $location_id)
            ->where('type','<>','util')
            ->where('start','<=',$now)
            ->where('end'  ,'>', $now)
            ->inRandomOrder()->get();

        while ($i<$nscreens) {
            $previ = $i; // para romper bucles infinitos
            foreach ($messages as $message){
                $envelope = new Envelope();
                $envelope->stext = $message->stext;
                $envelope->ltext = $message->ltext;
                $envelope->image = $message->image;
                $envelope->background = $message->imagebig;
                $envelope->type = 'info';
                $envelope->logo1 = isset($message->location)?$message->location->logo:"";
                //Log::info('Delay AGENDA:'.$delay);
                $job = new AdsEngine($envelope, $location_id);
                $i++;
                $a[] = $job;
                if ($i == $nscreens)
                    return $a;
            }
            if ($previ == $i)// si en una iteración el valor de i es igual al inicial rompemos el bucle.
                return $a;
        }
        return $a;
    }
}
