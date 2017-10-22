<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $guarded = ['id'];
    static $searchable = ['title','text'];
    protected $path = 'notification';

    public function location()
    {
        return $this->belongsTo('App\Location','location_id','id');
    }

    public function getPathAttribute()
    {
        return $this->table.'/'.$this->path.$this->id;
    }


    public function who(){
        if ($this->who == 0)
            return "A todos los usuarios";

        $game = Gameboard::find($this->who);
        if (isset($game))
            return trans('label.notifications.participantes'). $game->name;
        return "Indefinido";
    }
}
