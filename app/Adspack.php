<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Illuminate\Database\Eloquent\Model;


class Adspack extends Model
{
    protected $guarded = ['id','advertisement_id'];

    protected $table = 'adspacks';


    public function advertisement()
    {
        return $this->belongsTo('App\Advertisement');
    }

    public function totalbig()
    {
        return $this->bigpack*100;
    }

    public function totalsmall()
    {
        return $this->smallpack*100;
    }
    
    public function tot alAds()
    {
        return $this->bigpack*100 + $this->smallpack*100;
    }

    public function totalCost()
    {
        return $this->bigpack*1 + $this->smallpack*0.60;
    }

}
