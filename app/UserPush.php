<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPush extends Model
{
    protected $table = 'push_users';
    protected $casts = [ 'id' => 'string' ];

    public function location()
    {
        return $this->hasOne('App\Location');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
