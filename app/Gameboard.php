<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\ScreenEvent;


class Gameboard extends Model
{
    protected $table = 'gameboards';
    protected $guarded = ['id'];

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

    public function gameboardUsers()
    {
        return $this->hasMany('App\UserGameboard');
    }

    public function gameViews()
    {
        return $this->hasMany('App\GameView');
    }

    public function getStartdateAttribute($value)
    {
        if (!isset($value))
            return Carbon::createFromTimestamp($this->activity->starttime->getTimestamp());
        return $value;
    }

    public function EndtimeAttribute($value)
    {
        if (!isset($value))
            return $this->activity->endtime;
        return $value;

    }

    public function getDeadlineAttribute($value)
    {
        if (!isset($value))
            return $this->activity->deadline;
        else
            return $value;
    }

    public function getSelectionAttribute($value)
    {
        if (!isset($value))
            return $this->activity->selection;
        return $value;
    }

    public function getHead2headAttribute($value)
    {
        return $this->activity->head2head;
    }

    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getLocalStarttime()
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
        return sprintf("%05d", $this->id);
    }

    public function getGameId($value)
    {
        return ($value + 0);
    }


    public function destroyGame()
    {
        try{
            DB::beginTransaction();
            UserGameboard::where('gameboard_id',$this->id)->delete();
            GameView::where('gameboard_id',$this->id)->delete();

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
        $this->status = Status::SCHEDULED;
        $this->participation_status = true;       //open voting
        $this->starttime = $this->activity->starttime;
        $this->duration = $this->activity->duration;
        $this->deadline = $this->activity->deadline ;
        $this->description = $this->activity->description;
        $this->save();


        //Si el juego es auto, tendremos que crear las options a partir de la activity_options
        if ($this->auto) {
            $options = ActivityOption::where('activity_id', $this->activity_id)->get();
            foreach ($options as $activityOption) {
                $gameboardOption = new GameboardOption($this->id, $activityOption);
                $gameboardOption->save();
            }
        }

        // Además tenemos que crear las pantallas iniciales del juego.
        $this->createGameViews();


    }

    /**
     * Toda actividad tiene 4 pantallas: presentación , juego , ranking y finalización.
     * Estás pantallas no son estáticas sino que tienen que incluir llamadas al servidor para irse actualizando.
     * @param  Gameboard  $gameboard
     * @return boolean
     */
    public function createGameViews()
    {
        foreach(Status::$desc as $key => $value)
        {
            $presentation = new GameView();
            $presentation->createX($this,$key);
            $presentation->save();
        }

        return false;

    }

    public function getGameView()
    {
        return $this->gameViews->where('status', $this->status)->first();

    }

    public function publish()
    {
        //Publicamos la pantalla
        $gameview = $this->getGameView();
        if (isset($gameview))
            event(new ScreenEvent($gameview, 'location2'  /*. $location->id*/)); // De momento todo lo pintamos en la location2
    }

}
