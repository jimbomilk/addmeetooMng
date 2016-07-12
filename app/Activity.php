<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $table = 'activities';

    protected $fillable = ['name', 'grouping', 'selection', 'point_system','how','category_id','location_id','location_position_id','duration'];


    public function category()
    {
        return $this->belongsTo('App\Category');
    }


    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function locationPosition()
    {
        return $this->belongsTo('App\LocationPosition');
    }
}
