<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Illuminate\Database\Eloquent\Model;


class Advertisement extends Model
{
    protected $table = 'advertisements';
    protected $guarded = ['id'];
    protected $path = 'adv';

    public function category()
    {
        return $this->belongsTo('App\AdsCategory','category_id','id');
    }

    public function adspacks()
    {
        return $this->hasMany('App\AdsPack')->get();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getPathAttribute()
    {
        return 'anu/'.$this->path.$this->id;
    }


}
