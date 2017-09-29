<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserGameboard extends Model
{

    protected $table = 'user_gameboards';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function gameboard()
    {
        return $this->belongsTo('App\Gameboard');
    }

    public function getLocationAttribute()
    {
        return $this->gameboard->location_id;
    }


}
