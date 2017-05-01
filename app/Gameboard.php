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
        foreach($this->gameboardOptions as $option)
        {
            if (!isset($option->result))
                return false;
        }
        return true;
    }

    public function getStarttimeAttribute($value)
    {
        $st = ($this->auto)?$this->activity->starttime:$value;
        return $st;
    }


    public function getDeadlineAttribute($value)
    {
        if ($this->auto)
            return $this->activity->deadline;
        else
            return $value;
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
    public function getLocalStarttimeAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $starttime = Carbon::parse($this->starttime);
        $ret = $starttime->addHours($localoffset)->toTimeString();
        return $ret;
    }

    // Dado un valor local devolvemos su UTC
    public function getUTCStarttime()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $starttime = Carbon::parse($this->starttime);
        $ret = $starttime->subHours($localoffset)->toTimeString();
        return $ret;
    }


    public function getTypeAttribute($value)
    {
        return $this->activity->type;
    }


    public function getGameCode()
    {
        return sprintf('%04d', $this->id);
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
        $this->participation_status = true;       //open voting
        /*$this->starttime = $this->activity->starttime;
        $this->duration = $this->activity->duration;
        $this->deadline = $this->activity->deadline ;
        $this->description = $this->activity->description;*/
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

    /**
     * Toda actividad tiene 4 pantallas: presentación , juego , ranking y finalización.
     * Estás pantallas no son estáticas sino que tienen que incluir llamadas al servidor para irse actualizando.
     * @param  Gameboard  $gameboard
     * @return boolean
     */
    /*public function createGameViews()
    {
        // Primero las borramos todas
        GameView::where('gameboard_id',$this->id)->delete();
        foreach(Status::$desc as $key => $value)
        {
            $presentation = new GameView();
            $presentation->createX($this,$key);
            $presentation->save();
        }

        return false;

    }*/

    public function updateGameView()
    {
        $gameview = GameView::where('gameboard_id','=',$this->id,'and','status','=',$this->status)->first();
        if (!isset($gameview)) {
            $gameview = new GameView();
        }
        $gameview->createX($this,$this->status);
        $gameview->save();
        return $gameview;

    }

    public function getGameView()
    {
        //Log::info('Game View:'.$this->gameViews->where('status',$this->status+0) . ' status:'.$this->status);
        return $this->gameViews->where('status', $this->status)->first();

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
