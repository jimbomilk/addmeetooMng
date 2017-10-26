<?php

namespace App\Console\Commands;

use App\Adspack;
use App\Advertisement;
use App\Events\Envelope;
use App\Gameboard;
use App\Jobs\AdsEngine;
use App\Jobs\MsgEngine;
use App\location;
use App\Message;
use App\Status;
use App\User;
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
        //Log::info('Location:'.$location);

        //Recoger las categorias que admite el local y crear query para
        //filtra los ads : la query debe tener en cuanta las preferencias del local y su geolocalizacion

        if (isset($location)) {
            // En 10 minutos hay que meter n anuncios
            $nScreens = 0;
            $delay = 0;
            $alternate = true;
            while ( $delay < 600 ) {

                //Log::info('Delay smallADS:'.$delay);

                if($alternate)
                    $this->screenAds($location->id,$delay);
                else
                    $this->screenMsg($location->id,$delay);

                $alternate = !$alternate;

                $delay = $delay + 10; // Los mensajes duran 10 segundos

            }
        }

    }

    public function screenMsg($location_id, $delay)
    {
        /*$usergame = DB::table('user_gameboards')
            ->select('user_gameboards.user_id','user_gameboards.gameboard_id','gameboards.name as gamename','users.name as username','user_profiles.avatar as userimage')
            ->join('users','users.id','=','user_gameboards.user_id')
            ->join('user_profiles','user_profiles.user_id','=','user_gameboards.user_id')
            ->join('gameboards',function($join) use($location_id) {
                $join->on('gameboards.id', '=', 'user_gameboards.gameboard_id')
                    ->where ('gameboards.location_id','=',$location_id);
            })
            ->inRandomOrder()->first();*/


        $query = "select gameboards.name as gamename,users.name as username,user_profiles.avatar as userimage".
            " from user_gameboards".
            " inner join gameboards on gameboards.id=user_gameboards.gameboard_id and gameboards.location_id=".$location_id.
            " inner join users on users.id=user_gameboards.user_id".
            " inner join user_profiles on user_profiles.user_id=user_gameboards.user_id".
            " where gameboards.status > ".Status::SCHEDULED. " and gameboards.status<= ".Status::OFFICIAL.
            " order by RAND() LIMIT 1";

        $usergames = DB::select(DB::raw($query));

        if (!isset($usergames))
            return false;

        foreach($usergames as $usergame) {
            $msg = new Envelope();
            $msg->stext = strtoupper($usergame->username);
            $msg->ltext = $usergame->gamename;
            $msg->image = $usergame->userimage;
            $msg->type = 'message';

            $job = (new MsgEngine($msg, $location_id))
                ->delay($delay)
                ->onQueue('smallpack');

            $this->dispatch($job);
        }
        return true;
    }

    public function screenAds($location_id,$delay)
    {
        //Log::info('*** REQUEST ADS: ' . $advertisement_id . ' DELAY:'.$delay );

        $query = "select textsmall1,textsmall2,imagesmall,adspacks.id as packid from adspacks".
            " inner join advertisements on adspacks.advertisement_id=advertisements.id".
            " where adspacks.smallpack >= 0 and advertisements.location_id=".$location_id.
            " order by RAND() LIMIT 1";

        $adsPacks = DB::select(DB::raw($query));


        //Log::info('screenADS entrando');
        // recogemos el ads
        if (!isset($adsPacks))
            return false;


        //2 se lo enviamos a la cola de procesado
        foreach($adsPacks as $adspack) {
            $message = new Envelope();
            $message->ltext = $adspack->textsmall1;
            $message->stext = $adspack->textsmall2;
            $message->image = $adspack->imagesmall;
            $message->type = 'smallpack';

            $job = (new AdsEngine($message, $location_id))
                ->delay($delay)
                ->onQueue('smallpack');

            $this->dispatch($job);

            $pack = Adspack::find($adspack->packid);
            $pack->bigdisplayed++;
            $pack->save();
        }

        return true;
    }



}
