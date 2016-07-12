<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model {

    protected $table = 'bids';

    protected $fillable = ['price','bidder_id','item_id'];


    public function bidder()
    {
        return $this->hasOne('App\Bidder');
    }

    public function item()
    {
        return $this->hasOne('App\Item');
    }

}
