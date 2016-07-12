<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class location extends Model {

    protected $table = 'locations';

    protected $fillable = ['name'];


    public function positions()
    {
        return $this->hasMany('App\LocationPosition');
    }
    
    public function getGeolocationAttribute()
    {
        return $this->latitude . ','. $this->longitude;
    }

}
