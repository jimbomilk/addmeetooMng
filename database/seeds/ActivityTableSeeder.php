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
                $imagename = $option->path.'/'.utf8_encode($files[$i]);
                Storage::disk('s3')->put($imagename, file_get_contents($sourcefile), 'public');
                $option->image = Storage::disk('s3')->url($imagename);
                $option->save();
            }
        }


        return $activity_id;
    }


    public function newGame($activity_id,$location)
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


        $activity_id1 = $this->newActivity('¿QUE CURSO TE GUSTARÍA HACER?','ORDENALOS SEGUN TUS PREFERENCIAS','vote','encuesta',false,0);
        $activity_id2 = $this->newActivity('EL PARTIDAZO','ENVIA TU PRONOSTICO','bet','deporte',true,0);
        $activity_id3 = $this->newActivity('QUE CANTANTE TE GUSTARIA PARA LAS FIESTAS?','ORDENALOS SEGUN TUS PREFERENCIAS','vote','fiesta',false,0);



        //Para cada location creamos todos los juegos del día
        $locations = \App\Location::all();
        foreach($locations as $location){

            // Tenemos 3 juegos diferentes
            $this->newGame($activity_id1, $location->id);
            $this->newGame($activity_id2, $location->id);
            $this->newGame($activity_id3, $location->id);

        }


    }

}