<?php namespace App\Http\Middleware;

class IsAdmin extends IsType
{

    public function getType()
    {
        return 'admin';
    }
}