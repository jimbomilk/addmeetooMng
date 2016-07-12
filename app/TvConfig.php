<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TvConfig extends Model {

    protected $table = 'tvconfigs';

    protected $fillable = ['state','screen_timer','location_id'];


    public function location()
    {
        return $this->belongsTo('App\Location');
    }

}
