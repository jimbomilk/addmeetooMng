<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    
    protected $table = 'persons';


    protected $fillable = ['acr_id', 'name', 'photo'];

    
}
