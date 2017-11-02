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
        $total_time_by_type = 200;
        $total_time = 600;

        //Log::info('Location:'.$location);

        if (isset($location)) {
            $delay_screen=$location->screen_timer;
             // Tiempo que tiene cada sección (anuncios, info y actividades)
            $nScreens = round($total_time_by_type/$delay_screen);

            $agenda = $this->screenAgenda($location->id,$nScreens);
            $games = $this->screenGame($location->id,$nScreens);
            $anuncios = $this->screenAds($location->id,$nScreens);

            $jobs = array_merge($anuncios,$agenda,$games);
            shuffle($jobs);

            $delay = 0;
            $original = $jobs;
            while ($delay < $total_time)
            {
                $job = array_shift($jobs);
                if (isset($job)) {
                    $job->delay($delay);
                    $job->onQueue('bigpack');
                    if ($job->duration != 0)
                        $delay = $delay + $job->duration;
                    else
                        $delay = $delay + $delay_screen;
                    $this->dispatch($job);
                }
                else {
                    $delay = $delay + $delay_screen; // evitamos bucles infinitos
                }

                //Si nos quedamos sin elementos volvemos a empezar
                if (count($jobs)==0)
                    $jobs = $original;
            }
        }

    }

    public function screenAds( $location_id,$nScreens)
    {
        $now = Carbon::now(Config::get('app.timezone'))->toDateTimeString();

        $a = array();
        $query = "select textbig1,textbig2,imagebig,locations.logo as logo, adspacks.id as packid from adspacks".
                    " inner join advertisements on adspacks.advertisement_id=advertisements.id".
                    " left outer join locations on locations.id = advertisements.location_id".
                    " where advertisements.location_id=".$location_id.
                    " and adspacks.toscreen = 1 and adspacks.startdate <='". $now ."' and adspacks.enddate >'". $now ."'".
                    " order by adspacks.bigdisplayed limit ".$nScreens  ;

        $adsPacks = DB::select(DB::raw($query));
        if (!isset($adsPacks))
            return $a;

        foreach($adsPacks as $adspack) {
            $message = new Envelope();
            $message->ltext = $adspack->textbig1;
            $message->stext = $adspack->textbig2;
            $message->image = $adspack->imagebig;
            $message->type = 'bigpack';
            $message->logo1 = $adspack->logo;

            // actualizar sus visualizaciones
            $pack = Adspack::find($adspack->packid);
            if (isset($pack)) {
                $pack->bigdisplayed++;
                $pack->save();
            }
            // creamos el job
            $job = (new AdsEngine($message, $location_id));
            $a[] = $job;
        }
        return $a;
    }


    public function screenGame($location_id,$nscreens)
    {
        $a = array();

        foreach (Gameboard::where('location_id', '=', $location_id)
                     ->where('status', '>', Status::SCHEDULED)
                     ->where('status', '<=', Status::OFFICIAL)
                     ->limit($nscreens)
                     ->cursor() as $gameboard) {
            $gameview = $gameboard->getGameView($gameboard->status);
            if (isset($gameview)) {
                //Log::info('Delay GAME:'.$d);
                $job = (new GameEngine($gameview, $location_id));
                $a[] = $job;

            }
        }

        return $a;
    }

    public function screenAgenda($location_id,$nscreens)
    {
        $a = array();
        $now = Carbon::now(Config::get('app.timezone'))->toDateTimeString();

        $messages = Message::where('location_id', '=', $location_id)
            ->where('type','<>','util')
            ->where('start','<=',$now)
            ->where('end'  ,'>', $now)
            ->where('toscreen',true)
            ->limit($nscreens)
            ->inRandomOrder()->get();

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
            if (isset($message->duration) && $message->duration !=0)
                $job->duration = $message->duration;
            $a[] = $job;
        }
        return $a;
    }
}
