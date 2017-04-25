<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 22/02/2015
 * Time: 20:13
 */

class UserTableSeeder extends Seeder {

    /**
     *
     */

    

    public function run()
    {

        $faker = Faker::create();
        $gender = null;

        for ($i = 0; $i < 100; $i ++)
        {   
            $gender = rand(0,1)==0?'male':'female';
            $id = \DB::table('users')->insertGetId( array(
                
                'name'      => $faker->name($gender),
                'email'     => "test".$i,
                'password'  => \Hash::make('123456'),
                'type'      => $faker->randomElement(['user','owner'])
            ) );

            \DB::table('user_profiles')->insert( array (
                'user_id'   => $id, 
                'birth_date'=> $faker->dateTimeBetween('-65 years','-15 years')->format('Y-m-d'),
                'gender'    => $gender,
                'bio'       => $faker->paragraph(rand(1,4)),
                'phone'     => $faker->phoneNumber,
                'avatar'    => $faker->imageUrl(64, 48),
                'points'    => $faker->numberBetween(50,2000),
                'rank_city'    => $faker->randomNumber(2),
                'rank_national'    => $faker->randomNumber(4),
                'rank_regional'    => $faker->randomNumber(3)

            ));
        }
    }

}