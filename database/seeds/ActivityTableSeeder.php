<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;

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

    

    public function newActivity($location,$name,$description,$type,$category,$head2head,$selection,$progression_type,$options)
    {

        $faker = Faker::create();

        $start = $faker->dateTimeBetween('+10 hour','+20 hour');
        $ending = Carbon::createFromTimeStamp($start->getTimestamp());
        $deadline = $faker->numberBetween(-30,+30);

        //***********************************************************************************
        //Activity
        $activity_id = \DB::table('activities')->insertGetId( array(

            'name'                  => $name,
            'description'           => $description,
            'starttime'             => $start,
            'endtime'               => $ending,
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
            'endtime'               => $ending,
            'deadline'              => $deadline,
            'selection'             => $selection,
            'progression_type'      => $progression_type,
            'activity_id'           => $activity_id,
            'location_id'           => $location,
            'selection'             => $selection,
            'status'                => 'running'

        ) );


        //Cogemos un usuario aleatorio
        $users = \DB::table('users')->where('type', '=', 'user' );
        $iduser = $faker->randomElement($users->lists('id'));

        // Creamos GameboardUser

        $gameboard_user = \DB::table('user_gameboards')->insertGetId( array(
            'gameboard_id'          => $gameboard_id,
            'user_id'               => $iduser,
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

            $gameboard_user_option  = \DB::table('user_gameboard_options')->insertGetId( array(
                'user_gameboard_id'     => $gameboard_user,
                'value'                 => $faker->numberBetween(0,12)

            ) );


        }

        // Creamos las game_views


        for ($i=0; $i < 10; $i++) {

            $messages = array();
            for ($j = 0; $j < 10; $j++) {
                // get a random digit, but always a new one, to avoid duplicates
                $messages [] = $faker->text(20);
            }

            $max = \DB::table('game_views')->max('id');

            $game_view = \DB::table('game_views')->insertGetId(array(
                'gameboard_id' => $gameboard_id,
                'logo1' => "/images/logo_modern_big_white.png",

                'headerMain' => $faker->text(20),
                'headerSub' => $faker->text(20),
                'logo2' => $faker->imageUrl($width = 640, $height = 480),
                'body' => $faker->text(200),
                'next' =>  $max+2,
                'messages' => json_encode($messages)

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
            'latitude'      => $faker->latitude($min = -90, $max = 90),     // 77.147489
            'longitude'     => $faker->longitude($min = -180, $max = 180),  // 86.211205
            'logo'          => $faker->image()
        ));

        for($i=0;$i<4;$i++)
        {
            $idscreen = \DB::table('screens')->insertGetId( array(

                'description'   => 'TV_' + $faker->text(20),
                'latitude'      => $faker->latitude($min = -90, $max = 90),     // 77.147489
                'longitude'     => $faker->longitude($min = -180, $max = 180),  // 86.211205
                'location_id'   => $idlocation1
            ));
        }

        $idlocation2 = \DB::table('locations')->insertGetId( array(
            'name'          => 'Bar Pepe',
            'owner_id'         => $idowner,
            'latitude'      => $faker->latitude($min = -90, $max = 90),     // 77.147489
            'longitude'     => $faker->longitude($min = -180, $max = 180),  // 86.211205
            'logo'          => $faker->image()
        ));

        for($i=0;$i<2;$i++)
        {
            $idscreen = \DB::table('screens')->insertGetId( array(

                'description'   => 'TV_' + $faker->text(20),
                'latitude'      => $faker->latitude($min = -90, $max = 90),     // 77.147489
                'longitude'     => $faker->longitude($min = -180, $max = 180),  // 86.211205
                'location_id'   => $idlocation2
            ));
        }

        $idlocation3 = \DB::table('locations')->insertGetId( array(
            'name'          => 'Xanadu Shopping Mall',
            'owner_id'      => $idowner,
            'latitude'      => $faker->latitude($min = -90, $max = 90),     // 77.147489
            'longitude'     => $faker->longitude($min = -180, $max = 180),  // 86.211205
            'logo'          => $faker->image()
        ));

        for($i=0;$i<10;$i++)
        {
            $idscreen = \DB::table('screens')->insertGetId( array(

                'description'   => 'TV_' + $faker->text(20),
                'latitude'      => $faker->latitude($min = -90, $max = 90),     // 77.147489
                'longitude'     => $faker->longitude($min = -180, $max = 180),  // 86.211205
                'location_id'   => $idlocation3
            ));
        }

        $start = $faker->dateTimeBetween('+10 hour','+20 hour');
        $ending = Carbon::createFromTimeStamp($start->getTimestamp());
        $now = Carbon::now(new DateTimeZone(Config::get('app.timezone')));
        $duration = $faker->numberBetween(10,40);
        $ending->addMinutes($duration);
        $deadline = $faker->dateTimeBetween('+1 hour','+10 hour');


        if ($now>$ending)
            $status = 'finished';
        elseif ($now>$start && $now<$ending)
            $status = 'running';
        else $status = 'ready';


        //Voting activity
        //***********************************************************************************
        //Activity

        $options = array('spain','france','russia','netherland','italy','swiss','portugal','great britain',
            'germany','belgium','israel','turkey','greece','lituania','slovenia','chipre','andorra');

        $this->newActivity($idlocation1,'Eurovision','Elige tu canción favorita','vote','party',false,12,'ordered',$options);


        //Betting Activity
        //***********************************************************************************
        $options = array('Real Madrid','Barcelona');
        $this->newActivity($idlocation2,'El Partidazo','Introduce el resultado','bet','sports',true,0,'ordered',$options);

        //Game Activity
        //***********************************************************************************
        $options = array('que rio pasa por madrid?','done esta la mpntaña más alta de españa?','quien inventó la bombilla?','Como se llama el rey de españa?','donde esta la sagrada familia?','quien es cristiano ronaldo?', 'que pais gano eurovision el año pasado?', 'quien es maradona?', 'donde se celebro el mundial del 82?');
        $this->newActivity($idlocation3,'Gymkana','Busqueda del tesoro','game','party',false,0,'random',$options);



        /*for ($j = 0; $j < 3; $j ++)
        {

            for ($k = 0; $k < 5; $k ++)
            {

                $id = \DB::table('activities')->insertGetId( array(

                    'name'                  => $faker->word(),

                    'description'           => $faker->text(200),
                    'start'                 => $start,
                    'state'                 => $status,
                    'duration'              => $duration,
                    'ending'                => $ending,

                    'selection'             => $faker->randomElement(['random','best']),
                    'point_system'          => $faker->randomElement(['bypoint','bytime']),
                    'how'                   => $faker->randomElement(['byposition','bypairing']),
                    'category_id'           => $idcategory,
                    'location_id'           => $idlocation,
                    'location_position_id'  => $idposition,
                    'duration'              => $faker->numberBetween(5,720)
                ) );



            }

        }

        */





    }

}