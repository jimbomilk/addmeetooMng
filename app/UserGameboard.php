<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
