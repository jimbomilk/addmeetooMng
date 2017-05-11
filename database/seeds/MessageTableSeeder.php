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

class MessageTableSeeder extends Seeder
{

    /**
     *
     */

    

    public function run()
    {

        $faker = Faker::create();

        //Cogemos un usuario aleatorio
        $locations = \DB::table('locations');
        $idlocation = $faker->randomElement($locations->lists('id'));

        for ($i = 0; $i < 30; $i ++)
        {
            $idlocation = $faker->randomElement($locations->lists('id'));

            $iditem = \DB::table('messages')->insertGetId( array(
                'stext'         => $faker->text(25),
                'ltext'         => $faker->text(50),
                'image'         => str_replace('http','https',$faker->imageUrl(64, 48)),
                'type'          => $faker->randomElement(['user','advertisement']),

                'location_id'   => $idlocation,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString()
            ));


        }
    }
};