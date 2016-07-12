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

    

    public function run()
    {

        $faker = Faker::create();
        $gender = null;
        $idlocation = null;
        $idposition= null;

        for ($i = 0; $i < 3; $i ++)
        {

            $idcategory = \DB::table('categories')->insertGetId( array(
                'code'          => $faker->word(),
                'description'   => $faker->sentence(),
                'gender'        => $faker->randomElement(['male','female','mixed']),
                'minAge'        => $faker->numberBetween(15,25),
                'maxAge'        => $faker->numberBetween(26,65)
            ));

            $owners = \DB::table('users')->where('type', '=', 'owner' );
            $idowner = $faker->randomElement($owners->lists('id'));

            $idlocation = \DB::table('locations')->insertGetId( array(
                'name'          => $faker->word(),
                'owner'         => $idowner,
                'latitude'      => $faker->latitude($min = -90, $max = 90),     // 77.147489
                'longitude'     => $faker->longitude($min = -180, $max = 180),  // 86.211205
            ));

            $start = $faker->dateTimeBetween('-1 hour','+1 hour');
            $ending = Carbon::createFromTimeStamp($start->getTimestamp());
            $now = Carbon::now(new DateTimeZone(Config::get('app.timezone')));
            $duration = $faker->numberBetween(10,40);
            $ending->addMinutes($duration);

            if ($now>$ending)
                $status = 'finished';
            elseif ($now>$start && $now<$ending)
                $status = 'running';
            else $status = 'ready';

            for ($j = 0; $j < 3; $j ++)
            {

                $idposition = \DB::table('location_positions')->insertGetId( array(
                    'description'       => $faker->word(),
                    'barcode'           => $faker->ean13(),
                    'location_id'       => $idlocation

                ));

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
        }




    }

}