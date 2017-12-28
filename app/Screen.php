<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model {

    protected $table = 'screens';

    public function location()
    {
        return $this->belongsTo('App\Location','location_id','id');
    }

}
