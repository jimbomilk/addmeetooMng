<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $table = 'items';
    protected $guarded = ['id'];
    static $searchable = ['name','description'];


    public function auction()
    {
        return $this->hasOne('App\Auction');
    }

}
