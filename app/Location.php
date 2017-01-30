<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class location extends Model {

    protected $table = 'locations';

    protected $fillable = ['name'];


    public function screens()
    {
        return $this->hasMany('App\Screen');
    }

    public function getGeolocationAttribute()
    {
        return $this->latitude . ','. $this->longitude;
    }

    public function owner()
    {
        return $this->belongsTo('App\User','owner_id','id');
    }

    public function gameboards()
    {
        return $this->hasmany('App\Gameboard');
    }

}
