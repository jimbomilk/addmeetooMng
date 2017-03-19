<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameboardOption extends Model
{
    protected $table = 'gameboard_options';

    protected $fillable = ['gameboard_id','activity_option_id'];


    public function __construct($game_id=null,$activity_option=null,$attributes = array())
    {
        parent::__construct($attributes);
        $this->gameboard_id = !is_null($game_id) ? $game_id : null;

        if (!is_null($activity_option))
        {
            $this->activity_option_id = $activity_option->id;
            $this->description = $activity_option->description;
            $this->image = $activity_option->image;
            $this->order = $activity_option->order;
        }
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
}
