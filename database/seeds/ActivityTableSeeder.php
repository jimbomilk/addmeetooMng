<?php
use App\Status;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Config;

/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 22/02/2015
 * Time: 20:13
 */

class ActivityTableSeeder extends Seeder {

    /**
     *
     */

    public function newActivity($start, $duration,$name,$description,$type,$category,$head2head,$selection)
    {
        $faker = Faker::create();
        $deadline = $faker->numberBetween(-30,+30);
        //***********************************************************************************
        //Activity
        $activity_id = \DB::table('activities')->insertGetId( array(

            'name'                  => $name,
            'description'           => $description,
            'starttime'             => $start,
            'duration'              => $duration,
            'deadline'              => $deadline,
            'type'                  => $type,
            'category'              => $category,
            'head2head'             => $head2head,
            'selection'             => $selection

        ) );

        //Recogemos las opciones
        $source = storage_path().'/app/private/activities/'.$name;
        $dir = opendir($source);
        $files = array();
        while ($current = readdir($dir)){
            if( $current != "." && $current != "..") {
                $files[] = $current;
            }
        }

        for($i=0; $i<count( $files ); $i++) {


            $activity_option = \DB::table('activity_options')->insertGetId(array(
                'order' => $i+1,
                'description' => utf8_encode(pathinfo($files[$i], PATHINFO_FILENAME)),
                'activity_id' => $activity_id
            ));

            //Guardamos la imagen
            $option = \App\ActivityOption::findOrFail($activity_option);
            if (isset($option))
            {
                $sourcefile= $source.'/'.$files[$i];
                $target = storage_path('app/public/').$option->path.'/';
                //Creamos el directorio si no existiese
                if (!file_exists($target)) {
                    mkdir($target, 0777, true);
                };


                copy($sourcefile, $target.utf8_encode($files[$i]));
                $option->image=$option->path.'/'.utf8_encode($files[$i]);
                $option->save();
            }
        }


        return $activity_id;
    }


    public function newGame($activity_id,$location,$start, $duration)
    {

        $faker = Faker::create();

        //Gameboard
        $gameboard_id =  \DB::table('gameboards')->insertGetId( array(
            'auto'                  => 1,
            'participation_status'  => 1,
            'starttime'             => $start,
            'duration'              => $duration,
            'activity_id'           => $activity_id,
            'location_id'           => $location,
            'status'                => Status::DISABLED
        ) );

        // Creamos las game options
        $gameboard = \App\Gameboard::findOrFail($gameboard_id);
        if (isset($gameboard))
            $gameboard->createGame();

        //Creamos usuarios del juego
        for ($k=0;$k<20 ;$k++) {
            $users = \DB::table('users')->where('type', '=', 'user');
            $iduser = $faker->randomElement($users->lists('id'));
            $gameboarduser = \DB::table('user_gameboards')->insertGetId(array(
                'points' => $faker->numberBetween(10, 10000),
                'gameboard_id' => $gameboard_id,
                'user_id' => $iduser
            ));
        }
    }


    public function run()
    {

        $faker = Faker::create();
        $gender = null;
        $idlocation = null;
        $idposition= null;


        $source = storage_path().'/app/private/locations';
        $dir = opendir($source);
        $files = array();
        while ($current = readdir($dir)){
            if( $current != "." && $current != "..") {
                $files[] = $current;
            }
        }

        $owners = \DB::table('users')->where('type', '=', 'owner' );
        for($i=0; $i<count( $files ); $i++) {
            $source = storage_path().'/app/private/locations';
            $target = storage_path().'/app/public/location';
            $target_name = 'location';

            $idowner = $faker->randomElement($owners->lists('id'));
            $idlocation = \DB::table('locations')->insertGetId( array(
                'name'          => 'Lugar',
                'owner_id'      => $idowner,
                'countries_id'    => 724,
                'logo'          => $target_name.($i+1).'/'.$files[$i]
            ));

            $target .= $idlocation;
            //Creamos el directorio si no existiese
            if (!file_exists($target)) {
                mkdir($target, 0777, true);
            };

            $source = $source . '/' . $files[$i];
            $target = $target . '/' . $files[$i];
            //Cogemos la imagen y la guardamos en su carpeta correspondiente
            copy($source, $target);

        }


        //Voting activity
        //***********************************************************************************
        //Activity

        $start = Carbon::createFromTime(9,0,0,'UTC');
        $oneday = Carbon::createFromTime(9,0,0,'UTC');
        $oneday->addDay(1);



        $duration = 30;



        //Para cada location creamos todos los juegos del día
        $locations = \App\Location::all();
        foreach($locations as $location){

            while ($start < $oneday) {
                // Tenemos 3 activities diferentes
                $start = $start->addMinutes($duration);
                $activity_id1 = $this->newActivity($start, $duration,'partido','INTRODUCE RESULTADO','bet','sports',true,0);
                $this->newGame($activity_id1, $location->id, $start, $duration);

                $start = $start->addMinutes($duration);
                $activity_id2 = $this->newActivity($start, $duration,'eurovision','ELIGE TU CANCION FAVORITA','vote','party',false,0);
                $this->newGame($activity_id2, $location->id, $start, $duration);

                $start = $start->addMinutes($duration);
                $activity_id3 = $this->newActivity($start, $duration,'cantantes','ELIGE TU CANTANTE FAVORITO','vote','party',false,0);
                $this->newGame($activity_id3, $location->id, $start, $duration);

            }
        }


    }

}