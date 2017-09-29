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

        $participationByDate =  DB::select( DB::raw("select IFNULL(date(a.created_at),'Sin Fecha') as participation_date,count(a.id) as participations
                    from user_gameboards a
                    left join gameboards b on b.id = a.gameboard_id
                    where b.location_id in (:locations)
                    group by date(participation_date)
                    order by date(participation_date)"), array('locations' => trim($locArray, ',')) );

        Log::info('participation:'.json_encode($participationByDate));

        return $participationByDate;
    }
}
