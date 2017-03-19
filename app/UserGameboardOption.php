<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGameboardOption extends Model
{
    //
    protected $table = 'user_gameboard_options';

    protected $fillable = ['activity_id','location_id'];


    public function userGameboard()
    {
        return $this->belongsTo('App\UserGameboard');
    }
}
