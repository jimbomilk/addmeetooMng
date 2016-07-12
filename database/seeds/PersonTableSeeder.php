<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $gender = null;

        for ($i = 0; $i < 100; $i ++)
        {   
            \DB::table('persons')->insert( array (
                'acr_id'   => $i*100000, 
                'name'      => $faker->name($gender),
                'photo'    => $faker->imageUrl(64, 48),
                    
              ));
        }
    }
}
