<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameView extends Model
{
    //
    protected $table = 'game_views';
    protected $guarded = ['id'];

    public function gameboard()
    {
        return $this->belongsTo('App\Gameboard');
    }

    public function createX($gameboard,$status)
    {
        $this->gameboard_id = $gameboard->getGameCode();

        $this->logo1 = $gameboard->location->logo;
        $this->logo2 = $gameboard->name;
        $this->headerMain = $gameboard->description;
        $this->status = $status;

        if ($status > Status::SCHEDULED)
            $this->headerSub = Status::$desc[$status];
        else
            $this->headerSub = 'Descargate la App de Addmeetoo y participa';

        $body = array();

        foreach ($gameboard->gameboardOptions as $option) {
            $body[] = [ 'order'=>$option->order,
                        'description'=>$option->description,
                        'image'=>$option->image,
                        'result'=>$option->result];
        }
        $this->body = json_encode($body);

    }


}
