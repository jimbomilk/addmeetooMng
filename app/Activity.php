<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $table = 'activities';

    protected $fillable = ['selection'];

    public function activityOptions()
    {
        return $this->hasMany('App\ActivityOption');
    }

    public function gameboards()
    {
        return $this->hasMany('App\Gameboard');
    }

}
