<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Adspack extends Model
{
    protected $guarded = ['id', 'advertisement_id'];

    protected $table = 'adspacks';


    public function advertisement()
    {
        return $this->belongsTo('App\Advertisement','advertisement_id','id');
    }

    public function totalbig()
    {
        return $this->bigpack * 100;
    }

    public function totalsmall()
    {
        return $this->smallpack * 100;
    }

    public function totalAds()
    {
        return $this->bigpack * 100 + $this->smallpack * 100;
    }

    public function totalCost()
    {
        return $this->bigpack * 1 + $this->smallpack * 0.60;
    }

    public function location()
    {
        $loc = $this->advertisement->location;
        //Log::info('$loc id:'.$loc->timezone);
        if (isset($loc))
            return $loc;
        return null;
    }

    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getVisibleStartdateAttribute()
    {
        setlocale(LC_TIME, 'es_ES');
        $localoffset = Carbon::now($this->location()->timezone)->offsetHours;
        $startdate = Carbon::parse($this->startdate);
        $ret = $startdate->addHours($localoffset)->format('d-M-y, H:i');
        return $ret;
    }
    public function getVisibleEnddateAttribute()
    {
        setlocale(LC_TIME, 'es_ES');
        $localoffset = Carbon::now($this->location()->timezone)->offsetHours;
        $enddate = Carbon::parse($this->enddate);
        $ret = $enddate->addHours($localoffset)->format('d-M-y, H:i');
        return $ret;
    }

    public function getUTCStartdate()
    {
        $localoffset = Carbon::now($this->location()->timezone)->offsetHours;
        $startdate = Carbon::parse($this->startdate);
        $ret = $startdate->subHours($localoffset);
        return $ret;
    }
    public function getUTCEnddate()
    {
        $localoffset = Carbon::now($this->location()->timezone)->offsetHours;
        $enddate = Carbon::parse($this->enddate);
        $ret = $enddate->subHours($localoffset);
        return $ret;
    }

    public function getLocalStartdateAttribute()
    {
        $localoffset = Carbon::now($this->location()->timezone)->offsetHours;
        $startdate = Carbon::parse($this->startdate);
        $ret = $startdate->addHours($localoffset)->format('Y-m-d\TH:i');
        return $ret;
    }

    public function getLocalEnddateAttribute()
    {
        $localoffset = Carbon::now($this->location()->timezone)->offsetHours;
        $enddate = Carbon::parse($this->enddate);
        $ret = $enddate->addHours($localoffset)->format('Y-m-d\TH:i');
        return $ret;
    }



}