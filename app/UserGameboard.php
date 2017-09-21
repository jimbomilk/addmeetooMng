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

    public static function getParticipationByDate($location_id)
    {
        $participationByDate =  DB::select( DB::raw("select date(a.created_at) as participation_date,count(a.id) as participations
                    from user_gameboards a
                    left join gameboards b on b.id = a.gameboard_id
                    where b.location_id = :location
                    group by date(created_at)
                    order by date(created_at) limit 8"), array('location' => $location_id) );

        Log::info('participation json:'.json_encode($participationByDate));

        return $participationByDate;
    }
}
