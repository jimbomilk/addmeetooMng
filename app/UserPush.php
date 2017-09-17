<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPush extends Model
{
    protected $table = 'user_push';
    protected $guarded = ['id'];


    public function location()
    {
        return $this->hasOne('App\Location');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
