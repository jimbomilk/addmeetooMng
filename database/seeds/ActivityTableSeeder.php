<?php
use App\Status;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

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

    public function newActivity($name,$description,$type,$category,$head2head,$selection)
    {
        $faker = Faker::create();

        //***********************************************************************************
        //Activity
        $activity_id = \DB::table('activities')->insertGetId( array(

            'name'                  => $name,
            'description'           => $description,
            'type'                  => $type,
            'category'              => $category,
            'head2head'             => $head2head,
            'selection'             => $selection

        ) );

        //Recogemos las opciones
        $source = storage_path().'/app/private/activities/'.$category;
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
                Storage::disk('s3')->put($option->path, file_get_contents($sourcefile), 'public');
                $option->image = Storage::disk('s3')->url($option->path);
                $option->save();
            }
        }


        return $activity_id;
    }


    public function newGame($activity_id,$name,$location)
    {

        $faker = Faker::create();
        $startgame = Carbon::now();
        $deadline = Carbon::now()->addDays(3);
        $endgame = Carbon::now()->addDays(3);
        //Gameboard
        $gameboard_id =  \DB::table('gameboards')->insertGetId( array(
            'auto'                  => 1,
            'startgame'             => $startgame,
            'deadline'              => $deadline,
            'endgame'               => $endgame,
            'name'                  => $name,
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
                'points' => (20-$k) * 100,
                'gameboard_id' => $gameboard_id,
                'user_id' => $iduser,
                'rank' => $k+1,
                'rankpo' => $k+1
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
                'name'          => 'Yuncos',
                'owner_id'      => $idowner,
                'countries_id'    => 724,
            ));

            //Creamos 2 comercios de Yuncos
            $idowner = $faker->randomElement($owners->lists('id'));
            \DB::table('locations')->insertGetId( array(
                'name'          => 'Comercio1',
                'owner_id'      => $idowner,
                'countries_id'  => 724,
                'parent_id'     => $idlocation
            ));

            $idowner = $faker->randomElement($owners->lists('id'));
            \DB::table('locations')->insertGetId( array(
                'name'          => 'Comercio2',
                'owner_id'      => $idowner,
                'countries_id'  => 724,
                'parent_id'     => $idlocation
            ));


            $sourcefile= $source.'/'.$files[$i];


            $location = \App\Location::find($idlocation);
            if(isset($location))
            {
                Storage::disk('s3')->put($location->path, file_get_contents($sourcefile), 'public');
                $location->logo = Storage::disk('s3')->url($location->path);
                $location->save();
            }


        }


        //Voting activity
        //***********************************************************************************
        //Activity


        $activity_id1 = $this->newActivity('OPINION - 5 OPCIONES','ORDENALOS SEGUN TUS PREFERENCIAS','vote','trabajo',false,0);
        $activity_id2 = $this->newActivity('PARTIDO - APUESTA','ENVIA TU PRONOSTICO','bet','deporte',true,0);
        $activity_id3 = $this->newActivity('OPINION FIESTA- 6 OPCIONES','ORDENALOS SEGUN TUS PREFERENCIAS','vote','fiesta',false,0);



        //Para cada location creamos todos los juegos del día
        $locations = \App\Location::all();
        foreach($locations as $location){

            // Tenemos 3 juegos diferentes
            $this->newGame($activity_id1,'¿QUÉ TIPO de CURSO TE GUSTARIA HACER?', $location->id);
            $this->newGame($activity_id2,'EL PARTIDAZO: APOYA A TU EQUIPO', $location->id);
            $this->newGame($activity_id3,'¿QUÉ GRUPO TE GUSTARÍA QUE TOCASE EN LAS FIESTAS?',$location->id);

        }


    }

}