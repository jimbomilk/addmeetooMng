<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $table = 'items';
    protected $guarded = ['id'];


    public function auction()
    {
        return $this->hasOne('App\Auction');
    }

}
