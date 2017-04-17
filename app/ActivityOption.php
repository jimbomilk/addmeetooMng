<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityOption extends Model
{
    protected $table = 'activity_options';
    protected $guarded = ['activity_id'];
    protected $path = 'option';

    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    public function getPathAttribute()
    {
        return $this->activity->path.'/'.$this->path.$this->id;
    }
}
