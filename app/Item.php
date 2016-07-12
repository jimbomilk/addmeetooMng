<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $table = 'items';

    protected $fillable = ['name', 'initial_price', 'max_price', 'photo','auction_id'];


    public function auction()
    {
        return $this->hasOne('App\Auction');
    }

}
