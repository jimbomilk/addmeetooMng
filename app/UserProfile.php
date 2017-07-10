<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
