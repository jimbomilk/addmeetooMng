<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Gameboard extends Model
{
    protected $table = 'gameboards';
    protected $fillable = ['name','activity_id','location_id','starttime','deadline','status'];

    public function activity()
    {
        return $this->belongsTo('App\Activity','activity_id','id');
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

    public function getTypeAttribute($value)
    {
        return $this->activity->type;
    }


    public function createGame()
    {
        $this->status = Status::SCHEDULED;

        $this->starttime = $this->activity->starttime;
        $this->endtime = $this->activity->endtime;
        $this->description = $this->activity->description;
        $this->save();

        //Recuperamos la activity y creamos los gameboard_options , copia de las activity options
        $options = ActivityOption::where('activity_id',$this->activity_id)->get();
        foreach ($options as $activityOption)
        {
            $gameboardOption = new GameboardOption($this->id,$activityOption);
            $gameboardOption->save();
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
            $presentation->status = $value;
            $presentation->createX($this);
            $presentation->save();
        }

        return false;

    }

    public function getGameView()
    {
        return $this->gameViews->where('status', $this->status)->first();

    }

}
