<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityOption extends Model
{
    protected $table = 'activity_options';

    protected $guarded = ['activity_id','result'];

    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }
}
