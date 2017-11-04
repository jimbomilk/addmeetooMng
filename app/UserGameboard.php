<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserGameboard extends Model
{

    protected $table = 'user_gameboards';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function gameboard()
    {
        return $this->belongsTo('App\Gameboard');
    }

    public function getLocationAttribute()
    {
        return $this->gameboard->location_id;
    }

    public static function getParticipationByDate($locations)
    {
        $locArray="";
        foreach($locations as $location) {
            $locArray .= $location->id;
            $locArray .= ",";
        }
        //Log::info('locations:'.$locArray);

        $participationByDate =  DB::select( DB::raw("select IFNULL(date(a.created_at),'2017-01-01') as participation_date,count(a.id) as participations
                    from user_gameboards a
                    left join gameboards b on b.id = a.gameboard_id
                    where b.location_id in (:locations)
                    group by date(participation_date)
                    order by date(participation_date)"), array('locations' => trim($locArray, ',')) );

        //::info('participation:'.json_encode($participationByDate));

        return $participationByDate;
    }

    public static function getParticipationByGame($game_id)
    {

        //Log::info('locations:'.$locArray);

        $participationByDate =  DB::select( DB::raw("select IFNULL(date(a.created_at),'2017-01-01') as participation_date,count(a.id) as participations
                    from user_gameboards a
                    left join gameboards b on b.id = a.gameboard_id
                    where b.id = " .$game_id.
                    " group by date(participation_date)
                     order by date(participation_date)"));

        //::info('participation:'.json_encode($participationByDate));

        return $participationByDate;
    }


    public static function getParticipation($game_id)
    {
        // Recoger los datos de participación de los hombres
        $query = "SELECT user_gameboards.values FROM user_gameboards"
            . " WHERE user_gameboards.values <> '' and "
            . " user_gameboards.gameboard_id = " . $game_id;

        $results = DB::select(DB::raw($query));
        // En head2head cada result es un array de 2 objetos {option,value}
        // En el resto sera un array de n objetos(uno por opcion)
        // En head2head hay que comparar los dos objetos para ver si es 1 X 2.
        $serie = array();
        $values = array();

        $gameboard = Gameboard::find($game_id);
        if (!isset($gameboard))
            return;

        if ($gameboard->head2head) {
            $val1 = 0;
            $valx = 0;
            $val2 = 0;

            foreach ($results as $i => $result) {
                $options = json_decode($result->values, true);
                //var_dump($options[0]);
                // $options es un array de 2 dimensiones: la primera dimension es la opcion y el segundo el valor/descripcion


                if ($i == 0) {
                    $serie[] = 'Gana ' . $options[0]['option'];
                    $serie[] = 'Empate';
                    $serie[] = 'Gana ' . $options[1]['option'];
                }

                if ($options[0]['value'] + 0 > $options[1]['value'] + 0)
                    $val1++;
                elseif ($options[0]['value'] + 0 == $options[1]['value'] + 0)
                    $valx++;
                elseif ($options[0]['value'] + 0 < $options[1]['value'] + 0)
                    $val2++;
            }
            $values = array($serie[0]=>$val1,$serie[1]=>$valx,$serie[2]=>$val2);
        } else {
            foreach ($results as $i => $result) {
                $options = json_decode($result->values, true);
                foreach ($options as $option) {
                    if ($i == 0) {
                        $values[$option['option']] = 0;
                    }
                    $values[$option['option']] = $values[$option['option']] + $option['value'];
                }
            }
        }
        return json_encode($values);
    }
}
