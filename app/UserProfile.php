<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserProfile extends Model {


	protected $table = 'user_profiles';
    protected $guarded = ['id'];

	public function getAgeAttribute()
	{
		return \Carbon\Carbon::parse($this->birth_date)->age;
	}

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function location()
    {
        return $this->hasOne('App\Location');
    }

    public function recalculateTopRank($location)
    {
        Log::info('useroptions3.1.4');
        $userprofiles = DB::select( DB::raw("select users.name as us_name,a.user_id, a.points, count(b.id)+1 as ranking
                    from user_profiles a
                    left join user_profiles b on a.points < b.points
                    inner join users on a.user_id = users.id
                    where a.location_id=".$location."
                    group by a.user_id
                    order by a.points desc, us_name asc") );
        Log::info('useroptions3.1.5');
        foreach ($userprofiles as $userrank)
        {

            $profile = UserProfile::find($userrank->user_id);
            if (isset($profile)) {
                $profile->rank = $userrank->ranking;
                $profile->save();
                Log::info('useroptions3.1.6:'.$profile->id);
            }
        }
    }

    public static function globalRanking($location,$paginated)
    {
        $user_profiles =  UserProfile::where('location_id','=',$location)
            ->select('users.id','users.name as us_name','user_profiles.*')
            ->join('users','user_profiles.user_id','=','users.id')
            ->orderBy('points', 'desc')
            ->orderBy('name', 'asc');
        if($paginated)
            return $user_profiles->paginate();

        return $user_profiles->take(10)->get();
    }


}
