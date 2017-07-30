<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','type'];
    static $searchable = ['name','email'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getPathAttribute()
    {
        return 'users'.'/user'.$this->id;
    }
    
    public function setPasswordAttribute($value)
    {
        if (!empty($value))
        {
            $this->attributes['password'] = bcrypt($value);
        }
    }

	public function profile()
	{
		return  $this->hasOne('App\UserProfile','user_id','id');
	}


    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function locations()
    {
        if ($this->type == 'admin')
            return Location::all();

        return $this->hasMany('App\Location','owner_id','id');
    }


    public function gameboards()
    {
        return $this->hasManyThrough('App\Gameboard', 'App\Location','owner_id','location_id','id');
    }



    public function scopeName($query,$name)
    {
        if (trim($name)!="")
        {
            $query->where('name', 'like', "%$name%");
        }
    }

    public function is($type)
    {

        return ($this->type == $type);
    }

    // SOCIAL MEDIA AUTH
    public function social()
    {
        return $this->hasMany('App\Social');
    }
}
