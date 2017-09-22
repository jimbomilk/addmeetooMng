<?php namespace App;



use Illuminate\Database\Eloquent\Model;

class Incidence extends Model {

    protected $table = 'incidences';
    protected $guarded = ['id'];
    static $searchable = ['user_id'];
    protected $path = 'incidence';

    public function locations()
    {
        return $this->belongsTo('App\Location','location_id','id');
    }

    public function getPathAttribute()
    {
        return $this->table.'/'.$this->path.$this->id;
    }


}
