<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model {

    protected $table = 'screens';

    protected $guarded = ['location_id'];


    public function location()
    {
        return $this->belongsTo('App\Location','location_id','id');
    }

}
