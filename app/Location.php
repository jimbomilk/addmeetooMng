<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class location extends Model {

    protected $table = 'locations';
    protected $guarded = ['id'];

    public function getImagesPathAttribute()
    {
        return 'location'.$this->id;
    }

    public function owner()
    {
        return $this->belongsTo('App\User','owner_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country','countries_id','id');
    }

    public function gameboards()
    {
        return $this->hasmany('App\Gameboard');
    }

    public function messages()
    {
        return $this->hasmany('App\Message');
    }



}
