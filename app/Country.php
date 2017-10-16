<?php namespace App;



use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    protected $table = 'countries';
    protected $guarded = ['id'];

    public function locations()
    {
        return $this->hasMany('App\Location');
    }



    public function calculateRankings($location)
    {
       //Ordenamos los Users por points
        $prev = 0;
        $rank = 0;
        $rankpo = 0;
        $sorted = UserProfile::where('location_id',$location)
            ->orderBy('points','desc');

        foreach ($sorted as $user_profile) {
            $rankpo++;
            if ($prev != $user_profile->points)
                $rank++;
            $prev = $user_profile->points;
            $user_profile->rank = $rank;
            $user_profile->rankpo = $rankpo;
            $user_profile->save();
        }
    }


}
