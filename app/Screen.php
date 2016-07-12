<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model {

    protected $table = 'screens';

    protected $fillable = ['name','order','type','state','ad_text','ad_image','activity_id','tvconfig_id'];


    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    public function tvconfig()
    {
        return $this->belongsTo('App\TvConfig');
    }
}
