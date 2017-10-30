<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','type','gamemanager','incidencemanager'];
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

	/*public function profile()
	{

		//return  $this->hasOne('App\UserProfile','user_id','id');
        return  $this->profiles()->first();
	}*/

    public function profiles()
    {
        return  $this->hasMany('App\UserProfile','user_id','id');
    }

    public function locationProfile($location)
    {
        // Se añade para adaptarlo a las versiones antiguas de la app
        if (!isset($location) || $location == null || $location == "")
            $location=1;

        return  $this->profiles()->where('location_id',$location)->first();
    }

    public function activities()
    {
        return $this->hasMany('App\Activity')->get();
    }

    public function locations()
    {
        if ($this->type == 'admin')
            return Location::all();

        return $this->hasMany('App\Location','owner_id','id')->get();
    }



    public function gameboards()
    {
        if ($this->type == 'admin')
            return Gameboard::all();
        return $this->hasManyThrough('App\Gameboard', 'App\Location','owner_id','location_id','id');
    }

    public function advertisements()
    {
        if ($this->type == 'admin')
            return Advertisement::paginate(10);
        return $this->hasManyThrough('App\Advertisement', 'App\Location','owner_id','location_id','id')->paginate(10);
    }

    public function statuses()
    {
        if ($this->type == 'admin')
            return Status::$desc;
        return Status::$descOwner;
    }

    public function messages($where)
    {

        if ($this->type == 'admin')
            return Message::whereRaw($where)->paginate(10);
        return $this->hasManyThrough('App\Message', 'App\Location','owner_id','location_id','id')
            ->whereRaw($where)
            ->paginate(10);
    }

    public function notifications($where)
    {
        if ($this->type == 'admin')
            return Notification::whereRaw($where)->paginate(10);
        return $this->hasManyThrough('App\Notification', 'App\Location','owner_id','location_id','id')
            ->whereRaw($where)
            ->paginate(10);
    }

    public function activeGameboards()
    {
        if ($this->type == 'admin')
            return Gameboard::where('status','=',Status::RUNNING)->get();
        return $this->hasManyThrough('App\Gameboard', 'App\Location','owner_id','location_id','id')
            ->where('status','=',Status::RUNNING)->get();
    }

    public function liveGameboards()
    {
        if ($this->type == 'admin')
            return Gameboard::where('status','>=',Status::SCHEDULED)
                ->where('status' ,'<=',Status::OFFICIAL)
                ->get();
        return $this->hasManyThrough('App\Gameboard', 'App\Location','owner_id','location_id','id')
            ->where('status','>=',Status::SCHEDULED)
            ->where('status' ,'<=',Status::OFFICIAL)
            ->get();
    }

    public function locationUsergames()
    {
        if ($this->type == 'admin')
            return UserGameboard::all();
        return $this->hasManyThrough('App\Gameboard', 'App\Location','owner_id','location_id','id')
            ->leftJoin('user_gameboards', 'gameboards.id', '=', 'user_gameboards.gameboard_id')
            ->select('user_gameboards.*');
    }

    public function locationUsers()
    {
       if ($this->type == 'admin')
            return User::all();
       return $this->hasManyThrough('App\UserProfile', 'App\Location','owner_id','location_id','id')
            ->leftJoin('users', 'user_profiles.user_id', '=', 'users.id')
            ->select('users.*');
    }

    public function incidences()
    {
        if ($this->type == 'admin')
            return Incidence::all();
        return $this->hasManyThrough('App\Incidence', 'App\Location','owner_id','location_id','id');
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

    public function getActivationCode()
    {
        $this->activationCode = str_random(60);
        $this->save();
    }
}
