<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidder extends Model {

    protected $table = 'bidders';

    protected $fillable = ['user_id'];


    public function user()
    {
        return $this->hasOne('App\User');
    }

}
