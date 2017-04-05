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

    

    public function newActivity($start, $duration, $location,$name,$description,$type,$category,$head2head,$selection,$progression_type,$options)
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

        //Gameboard
        $gameboard_id =  \DB::table('gameboards')->insertGetId( array(

            'name'                  => $name,
            'description'           => $description,
            'starttime'             => $start,
            'duration'              => $duration,
            'deadline'              => $deadline,
            'selection'             => $selection,
            'progression_type'      => $progression_type,
            'activity_id'           => $activity_id,
            'location_id'           => $location,
            'selection'             => $selection,
            'status'                => Status::SCHEDULED

        ) );



        $i=0;
        foreach ($options as $aux)
        {
            $i++;
            $activity_option = \DB::table('activity_options')->insertGetId( array(

                'order'                 => $i,
                'description'           => $aux,
                'image'                 => $faker->imageUrl($width = 640, $height = 480),
                'activity_id'           => $activity_id
            ) );

            $gameboard_option = \DB::table('gameboard_options')->insertGetId( array(

                'order'                 => $i,
                'description'           => $aux,
                'image'                 => $faker->imageUrl($width = 640, $height = 480),
                'gameboard_id'          => $gameboard_id,
                'activity_option_id'    => $activity_option
            ) );


        }

        // Creamos las game_views
        $gameboard = \App\Gameboard::findOrFail($gameboard_id);
        if (isset($gameboard))
            $gameboard->createGameViews();

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


        $owners = \DB::table('users')->where('type', '=', 'owner' );
        $idowner = $faker->randomElement($owners->lists('id'));

        $idlocation1 = \DB::table('locations')->insertGetId( array(
            'name'          => 'Disco Madrid80',
            'owner_id'         => $idowner,
            'countries_id'    => 724,
            'logo'          => $faker->imageUrl($width = 48, $height = 48)
        ));


        $idowner = $faker->randomElement($owners->lists('id'));
        $idlocation2 = \DB::table('locations')->insertGetId( array(
            'name'          => 'Bar Pepe',
            'owner_id'      => $idowner,
            'countries_id'    => 724,
            'logo'          => 'bar_white.png', // Logo del bar
        ));


        $idowner = $faker->randomElement($owners->lists('id'));
        $idlocation3 = \DB::table('locations')->insertGetId( array(
            'name'          => 'Xanadu Shopping Mall',
            'owner_id'      => $idowner,
            'countries_id'    => 724,
            'logo'          => $faker->imageUrl($width = 48, $height = 48)
        ));



        //Voting activity
        //***********************************************************************************
        //Activity
        $options_eurovision = array('spain','france','russia','netherland','italy','swiss','portugal','great britain',
            'germany','belgium','israel','turkey','greece','lituania','slovenia','chipre','andorra');
        $options_match1 = array('Real Madrid','Barcelona');

        $options_game = array('que rio pasa por madrid?','done esta la mpntaña más alta de españa?','quien inventó la bombilla?','Como se llama el rey de españa?','donde esta la sagrada familia?','quien es cristiano ronaldo?', 'que pais gano eurovision el año pasado?', 'quien es maradona?', 'donde se celebro el mundial del 82?');

        $options_match2 = array('Celta','Valladolid');

        $options_encuesta = array('mahou','estrella galicia','san miguel','buckler','guinness','bud');

        $options_match3 = array('At. Madrid','Valencia');

        $options_encuesta2 = array('madonna','michael jackson','raphael','rolling stone','sabina','rocio jurado');

        $start = Carbon::createFromTime(9,0,0,'UTC');
        $oneday = Carbon::createFromTime(9,0,0,'UTC');
        $oneday->addDay(1);

        $duration = 10;

        for ($i=0;$i<20 && $start<$oneday;$i++)
        {
            $this->newActivity($start,$duration,$idlocation2,'eurovision','EUROVISION: vota tu canción','vote','party',false,12,'ordered',$options_eurovision);
            $start = $start->addMinutes($duration);

            $this->newActivity($start,$duration,$idlocation1,'partidazo','EL PARTIDAZO','bet','sports',true,0,'ordered',$options_match1);
            $start = $start->addMinutes($duration);

            $this->newActivity($start,$duration,$idlocation3,'gymkana','Busqueda del tesoro','game','party',false,0,'random',$options_game);
            $start = $start->addMinutes($duration);

            $this->newActivity($start,$duration,$idlocation1,'viajeros','¿A que pais te gustaría viajar?','vote','party',false,12,'ordered',$options_eurovision);
            $start = $start->addMinutes($duration);

            $this->newActivity($start,$duration,$idlocation2,'partidazo','EL PARTIDAZO','bet','sports',true,0,'ordered',$options_match2);
            $start = $start->addMinutes($duration);

            $this->newActivity($start,$duration,$idlocation3,'encuesta','¿Cúal es tu cerveza favorita?','vote','party',false,3,'ordered',$options_encuesta);
            $start = $start->addMinutes($duration);

            $this->newActivity($start,$duration,$idlocation2,'partidazo','EL PARTIDAZO','bet','sports',true,0,'ordered',$options_match3);
            $start = $start->addMinutes($duration);

            $this->newActivity($start,$duration,$idlocation1,'encuesta','¿Cúal es tu cantante favorito?','vote','party',false,3,'ordered',$options_encuesta2);
            $start = $start->addMinutes($duration);

        }









    }

}