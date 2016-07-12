<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class locationPosition extends Model {

    protected $table = 'location_positions';

    protected $fillable = ['description','barcode'];

}
