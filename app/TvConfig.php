<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TvConfig extends Model {

    protected $table = 'tvconfigs';
    protected $guarded = ['id'];


    public function location()
    {
        return $this->belongsTo('App\Location');
    }

}
