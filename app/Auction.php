<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model {

    protected $table = 'auctions';
    protected $guarded = ['id'];


    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function winnerBid()
    {
        return $this->belongsTo('App\Bid','winner_bid','id');
    }

}
