<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model {

    protected $table = 'descriptions';

    public function language()
    {
        return $this->belongsTo('App\Language');
    }
}
