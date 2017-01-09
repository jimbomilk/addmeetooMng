<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model {


	 protected $table = 'user_profiles';

	public function getAgeAttribute()
	{
		return \Carbon\Carbon::parse($this->birth_date)->age;
	}

    public function user()
    {
        return $this->belongsTO('App\User', 'user_id', 'id');
    }

}
