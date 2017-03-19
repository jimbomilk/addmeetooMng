<?php namespace App\Http\Middleware;

class IsOwner extends IsType
{

    public function getType()
    {
        return 'owner';
    }
}