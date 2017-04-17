<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class GameboardOption extends Model
{
    protected $table = 'gameboard_options';
    protected $guarded = ['id'];
    protected $path='option';


    public function init($game_id=null,$activity_option=null)
    {
        $this->gameboard_id = !is_null($game_id) ? $game_id : null;

        if (!is_null($activity_option))
        {
            $this->activity_option_id = $activity_option->id;
            $this->description = $activity_option->description;
            $this->image = $activity_option->image;
            $this->order = $activity_option->order;
        }
    }

    public function getPathAttribute()
    {
        return $this->gameboard->path.'/'.$this->path.$this->id;
    }


    public function gameboard()
    {
        return $this->belongsTo('App\Gameboard','gameboard_id','id');
    }

    // Solo debe utilizarse para las actividades de betting, pues en el resto no tiene porque existir la relación.
    public function activityOption()
    {
        return $this->belongsTo('App\ActivityOption','activity_option_id','id');
    }


    // Los resultados vienen de la actividad porque está en modo automático.
    public function getResultAttribute($value)
    {
        if (isset($this->activity_option_id))
        {
            return $this->activityOption->result;
        }
        return $value;
    }
}
