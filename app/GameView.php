<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameView extends Model
{
    //
    protected $table = 'game_views';


    public function gameboard()
    {
        return $this->belongsTo('App\Gameboard');
    }

    public function createX($gameboard)
    {
        $this->gameboard_id = $gameboard->id;
        $this->logo1 = $this->urlRequest('logo_modern_big_white.png');
        $this->logo2 = $gameboard->location->logo; //de momento no servimos la imagen como debería
        $this->headerMain = $gameboard->name;
        $this->headerSub = Status::$desc[$gameboard->status];

        $body = array();

        if ($gameboard->type == 'vote' || $gameboard->type == 'bet') {
            foreach ($gameboard->gameboardOptions() as $option) {
                $body[] = $option->description;
            }
            $this->body = json_encode($body);
        } else //gymkana
        {
            $this->body = $gameboard->status;
        }

    }

    public function urlRequest($image,$location="")
    {
        // host + base + view + component + location + screen
        $ret =  "host/images/";
        if ($location != "")
            $ret .= "location/";
        $ret .= $image;

        return $ret;
    }

}
