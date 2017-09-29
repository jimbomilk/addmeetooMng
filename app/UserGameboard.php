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

    public static function getParticipationByDate($locations)
    {
        $locArray="";
        foreach($locations as $location) {
            $locArray .= $location->id;
            $locArray .= ",";
        }
        //Log::info('locations:'.$locArray);

        $participationByDate =  DB::select( DB::raw("select IFNULL(date(a.created_at),'2017-01-01') as participation_date,count(a.id) as participations
                    from user_gameboards a
                    left join gameboards b on b.id = a.gameboard_id
                    where b.location_id in (:locations)
                    group by date(participation_date)
                    order by date(participation_date)"), array('locations' => trim($locArray, ',')) );

        //::info('participation:'.json_encode($participationByDate));

        return $participationByDate;
    }
}
