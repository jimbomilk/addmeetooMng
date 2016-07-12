<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';


    protected $fillable = ['code', 'description', 'gender', 'minAge','maxAge'];

    public function features()
    {
        return $this->hasMany('App\CategoryFeatures');
    }

}
