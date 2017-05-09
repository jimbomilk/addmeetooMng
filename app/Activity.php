<?php namespace App;


/* Activity */
use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $table = 'activities';
    protected $guarded = ['id'];
    protected $path = 'activity';

    public function activityOptions()
    {
        return $this->hasMany('App\ActivityOption');
    }

    public function gameboards()
    {
        return $this->hasMany('App\Gameboard');
    }


    public function getPathAttribute()
    {
        return $this->table.'/'.$this->path.$this->id;
    }

}
