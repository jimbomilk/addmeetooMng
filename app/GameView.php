<?php

/* Por definición un Gameboard es una actividad (activity) desarrollada en un local (location) */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameView extends Model
{

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
        $this->logo2 = $gameboard->activity->name;
        $this->headerMain = $gameboard->description;
        $this->status = $status;


        if ($status <= Status::SCHEDULED) {
            $this->headerSub = 'Descárgate Addmeetoo en tu móvil y participa';
            $this->body = $this->scheduleBody($gameboard);
        }
        elseif ($status == Status::STARTLIST) {
            $this->headerSub = 'DATOS de PARTICIPACIÓN';
            $this->body = $this->startlistBody($gameboard);
        }
        elseif ($status >= Status::RUNNING && $status<Status::FINISHED) {
            $this->headerSub = 'EN VIVO';
            $this->body = $this->runningBody($gameboard);
        }
        elseif ($status == Status::FINISHED) {
            $this->headerSub = 'ACTIVIDAD FINALIZADA';
            $this->body = $this->finishedBody($gameboard);
        }
        elseif ($status == Status::OFFICIAL) {
            $this->headerSub = 'RESULTADOS';
            $this->body = $this->officialBody($gameboard);
        }
        else
            $this->headerSub = Status::$desc[$status];
    }

    private function scheduleBody($gameboard){
        $this->type='options';
        $body = array();
        foreach ($gameboard->gameboardOptions as $option) {
            $body[] = [ 'order'=>$option->order,
                        'description'=>$option->description,
                        'image'=>$option->image,
                        'result'=>$option->result];
        }
        return json_encode($body);
    }

    private function startlistBody($gameboard){
        $this->type='chart';
        $data = [];
        $chart = new Chart('ColumnChart');


        // Recoger los datos de participación de los hombres
        $query = "SELECT COUNT(*) as participacion FROM user_gameboards".
                 " WHERE user_gameboards.gameboard_id = ".$gameboard->id;

        $results = DB::select( DB::raw($query) );
        $chart->dataSeries[] = ['','Total'];
        foreach($results as $result){
            $chart->dataSeries[] = ['',$result->participacion];
        }
        Log::info('Datas:'.json_encode($chart));
        return json_encode($chart);
    }

    private function runningBody($gameboard){
        $body = array();
        $this->type='options';
        $body = array();
        foreach ($gameboard->gameboardOptions as $option) {
            $body[] = [ 'order'=>$option->order,
                'description'=>$option->description,
                'image'=>$option->image,
                'result'=>$option->result];
        }
        return json_encode($body);
    }

    private function finishedBody($gameboard){
        $body = array();

        $this->type='chart';
        $data = [];
        $chart = new Chart('ColumnChart');

        // Recoger los datos de participación de los hombres
        $query = "SELECT user_gameboards.values FROM user_gameboards"
            . " WHERE user_gameboards.values <> '' and "
            . " user_gameboards.gameboard_id = ". $gameboard->id;

        $results = DB::select( DB::raw($query) );
        // En head2head cada result es un array de 2 objetos {option,value}
        // En el resto sera un array de n objetos(uno por opcion)
        // En head2head hay que comparar los dos objetos para ver si es 1 X 2.
        if ($gameboard->head2head) {
            $chart->dataSeries[] = ['', '1', 'X', '2'];
            $val1 = 0;$valx = 0;$val2 = 0;
            $options = [];

            foreach ($results as $result)
            {
                $options = json_decode($result->values,true);
                var_dump($options[0]);
                // $options es un array de 2 dimensiones: la primera dimension es la opcion y el segundo el valor/descripcion
                if ($options[0]['value'] + 0 > $options[1]['value'] + 0)
                    $val1++;
                elseif ($options[0]['value'] + 0 == $options[1]['value'] + 0)
                    $valx++;
                elseif ($options[0]['value'] + 0 < $options[1]['value'] + 0)
                    $val2++;
            }

            $chart->dataSeries[] = ['', $val1, $valx, $val2];
        }

        //Log::info('Datas:'.json_encode($chart));
        return json_encode($chart);
    }

    private function officialBody($gameboard){
        $this->type='ranking';
        $body = array();
        // Recoger los datos de participación de los hombres
        $gameusers = UserGameboard::where('gameboard_id',$gameboard->id)
                    ->orderBy('rankpo', 'desc')
                    ->get();

        $body = array();
        foreach ($gameusers as $gameuser) {
            $body[] = [ 'order'=>$gameuser->rank,
                        'description'=>$gameuser->user->name,
                        'image'=>$gameuser->user->profile->avatar,
                        'result'=>$gameuser->points];
        }
        return json_encode($body);
    }
}
