<?php namespace App\Http\Middleware;

class IsUser extends IsType
{

    public function getType()
    {
        return 'user';
    }
}