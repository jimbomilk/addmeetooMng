<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function recalculateTopRank()
    {
        $userprofiles = DB::select( DB::raw("select users.name as us_name,a.user_id, a.points, count(b.id)+1 as ranking
                    from user_profiles a
                    left join user_profiles b on a.points < b.points
                    inner join users on a.user_id = users.id
                    group by a.user_id
                    order by a.points desc, us_name asc") );

        foreach ($userprofiles as $userrank)
        {
            $profile = UserProfile::findOrFail($userrank->user_id);
            if (isset($profile))
                $profile->rank = $userrank->ranking;
            $profile->save();
        }
    }


}
