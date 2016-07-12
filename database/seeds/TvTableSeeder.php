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

class TvTableSeeder extends Seeder
{

    /**
     *
     */

    

    public function run()
    {

        $faker = Faker::create();


        $locationid = $faker->numberBetween(1,\DB::table('locations')->count());

        for ($i = 0; $i < 30; $i ++)
        {
            $idtvconfig = \DB::table('tvconfigs')->insertGetId( array(
                'state'          => $faker->randomElement(['live','pause']),
                'screen_timer'   => $faker->numberBetween(5,25),
                'location_id'    => $locationid
            ));



            for ($j = 0; $j < 5; $j ++)
            {

                $activity = \DB::table('activities')->where('location_id', '=', $locationid );

                $idscreen = \DB::table('screens')->insertGetId(array(
                    'name'          => $faker->text(25),
                    'order'         => $faker->numberBetween(1,5),
                    'type'          => $faker->randomElement(['top_rank','activity_rank','messages','advertisement']),
                    'state'         => $faker->randomElement(['on','off']),
                    'ad_text'       => $faker->text(25),
                    'ad_img'        => $faker->imageUrl(64,48),
                    'activity_id'   => $faker->randomElement($activity->lists('id')),
                    'tvconfig_id'   => $idtvconfig
                ));
            }

      }
    }
};