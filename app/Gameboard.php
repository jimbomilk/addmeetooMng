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




}
