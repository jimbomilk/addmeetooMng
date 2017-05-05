<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Illuminate\Database\Eloquent\Model;


class Adscategory extends Model
{
    protected $guarded = ['id'];

    protected $table = 'adscategories';

}
