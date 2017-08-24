<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Gameboard extends Model
{
    protected $table = 'gameboards';
    protected $guarded = ['id'];
    protected $path = 'gameboard';

    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function gameboardOptions()
    {
        return $this->hasMany('App\GameboardOption');
    }

    public function getNameAttribute($value)
    {
        if($this->auto && !isset($value))
            return $this->activity->name;
        return $value;
    }

    public function getDescriptionAttribute($value)
    {
        if(!isset($value)&&$this->auto)
            return $this->activity->description;
        return $value;
    }

    public function getPathAttribute()
    {
        return $this->table.'/'.$this->path.$this->id;
    }

    public function gameboardUsers()
    {
        return $this->hasMany('App\UserGameboard');
    }

    public function gameViews()
    {
        return $this->hasMany('App\GameView');
    }


    public function getHasResults()
    {
        // Una votación siempre tiene resultados por eso devolvemos true
        if ($this->activity->type == 'vote')
            return true;

        foreach($this->gameboardOptions as $option)
        {
            if (!isset($option->result))
                return false;
            if ($option->result < 0)
                return false;
        }
        return true;
    }

    /* If the participation has finished, return false */
    public function getParticipationStatusAttribute()
    {

        if(!isset($deadline))
            return true;

        $now = Carbon::now();
        $deadline = Carbon::parse($this->deadline);
        if ($now>=$deadline)
            return false;
        return true;
    }

    public function getSelectionAttribute($value)
    {
        if ($this->auto)
            return $this->activity->selection;
        return $value;
    }

    public function getHead2headAttribute($value)
    {
        return $this->activity->head2head;
    }

    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getLocalStartgameAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $startgame = Carbon::parse($this->startgame);
        $ret = $startgame->addHours($localoffset)->format('Y-m-d\TH:i');
        return $ret;
    }

    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getLocalEndgameAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $endgame = Carbon::parse($this->endgame);
        $ret = $endgame->addHours($localoffset)->format('Y-m-d\TH:i'); // 1975-12-25T14:15

        return $ret;
    }

    public function getLocalDeadlineAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $deadline = Carbon::parse($this->deadline);
        $ret = $deadline->addHours($localoffset)->format('Y-m-d\TH:i'); // 1975-12-25T14:15

        return $ret;
    }



    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getVisibleStartgameAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $startgame = Carbon::parse($this->startgame);
        $ret = $startgame->addHours($localoffset)->format('d-M');
        return $ret;
    }

    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getVisibleEndgameAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $endgame = Carbon::parse($this->endgame);
        $ret = $endgame->addHours($localoffset)->format('d-M');

        return $ret;
    }

    public function getVisibleDeadlineAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $deadline = Carbon::parse($this->deadline);
        $ret = $deadline->addHours($localoffset)->format('d-M H:i'); // 1975-12-25T14:15

        return $ret;
    }


    // Dado un valor local devolvemos su UTC
    public function getUTCStartgame()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $startgame = Carbon::parse($this->startgame);
        $ret = $startgame->subHours($localoffset);
        return $ret;
    }

    public function getUTCEndgame()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $endgame = Carbon::parse($this->endgame);
        $ret = $endgame->subHours($localoffset);
        return $ret;
    }

    public function getUTCDeadline()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $deadline = Carbon::parse($this->deadline);
        $ret = $deadline->subHours($localoffset);
        return $ret;
    }


    public function getTypeAttribute()
    {
        return $this->activity->type;
    }


    public function getGameCode()
    {
        return sprintf('%d', $this->id);
    }

    public function destroyGame()
    {
        try{
            DB::beginTransaction();
            UserGameboard::where('gameboard_id',$this->id)->delete();

            //Si el juego es auto, tendremos que borrar las gameboardoptions
            if ($this->auto) {
                GameboardOption::where('gameboard_id',$this->id)->delete();
            }
            DB::commit();
            return true;
        } catch(\PDOException $e)
        {
            DB::rollback();
            return false;
        }
    }

    public function createGame()
    {
        //status initilization
        $this->status = Status::DISABLED;
        $this->save();

        //Si el juego es auto, tendremos que crear las options a partir de la activity_options
        if ($this->auto) {
            // Primero  borramos todas sus opciones
            GameboardOption::where('gameboard_id',$this->id)->delete();

            //Cogemos las opciones de la actividad y las volvemos a crear
            $options = ActivityOption::where('activity_id', $this->activity_id)->get();
            foreach ($options as $activityOption) {
                $gameboardOption = new GameboardOption();
                $gameboardOption->init($this->id, $activityOption);
                $gameboardOption->save();
            }
        }
    }

    public function updateGameView()
    {
        // La participación siempre se actualiza
        /*$gameview = GameView::where('gameboard_id','=',$this->id,'and','status','=',Status::STARTLIST)->first();
        if (!isset($gameview)) {
            $gameview = new GameView();
        }
        $gameview->createX($this,Status::STARTLIST);
        $gameview->save();*/

        $gameview = GameView::where('gameboard_id','=',$this->id,'and','status','=',$this->status)->first();
        if (!isset($gameview)) {
            $gameview = new GameView();
        }
        $gameview->createX($this,$this->status);
        $gameview->save();
        return $gameview;

    }

    public function getGameView($status=null)
    {
        //Log::info('Game View:'.$this->gameViews->where('status',$this->status+0) . ' status:'.$this->status);
        if(!isset($status))
            return $this->gameViews->where('status', $this->status)->first();
        return $this->gameViews->where('status', $status)->first();

    }

    private function associativeOptions($values)
    {
        $output = array();
        foreach($values as $key => $value)
            $output[$value['option']]=$value['value'];
        return $output;
    }

    public function calculateRankings()
    {
        // Tenemos los resultados, por lo que hay que recorrer los usergames y asignar puntos.
        foreach($this->gameboardUsers as $user_game)
        {
            $user_game->rank = 0;
            $user_game->rankpo = 0;
            $user_game->temp_points = 0;
            $user_game->points=0;
            //recogemos su array de values
            $user_values = json_decode($user_game->values,true);

            if (isset($user_values)) {
                $user_options = $this->associativeOptions($user_values);
                $points = 0;
                foreach ($this->gameboardOptions as $option){
                    if ($user_options[$option->description] == $option->result)
                      $points++;
                }
                $user_game->temp_points = $points;
            }

        }

        //Ordenamos los Users por temp_points
        $prev=0;$rank=0;$rankpo=0;
        $sorted = $this->gameboardUsers->sortByDesc('temp_points');
        foreach($sorted as $user_game)
        {
            $rankpo++;
            if ($prev != $user_game->temp_points)
                $rank++;
            $prev=$user_game->temp_points;
            $user_game->rank = $rank;
            $user_game->rankpo = $rankpo;

            //Asignación de recompensas
            if ($user_game->temp_points>0) {
                if ($user_game->rank == 1)
                    $user_game->points = $this->activity->reward_first;
                if ($user_game->rank == 2)
                    $user_game->points = $this->activity->reward_second;
                if ($user_game->rank == 3)
                    $user_game->points = $this->activity->reward_third;
            }

            $user_game->save();

            // Además de acumular los puntos en el user_game se guardan en el user profile
            $user_game->user->profile->points += $user_game->points;
        }




    }


/*
    public function publish()
    {
        //Publicamos la pantalla
        $gameview = $this->getGameView();
        if (isset($gameview))
            event(new ScreenEvent($gameview, 'location'  . $location->id)); // De momento todo lo pintamos en la location2
    }
*/
}
