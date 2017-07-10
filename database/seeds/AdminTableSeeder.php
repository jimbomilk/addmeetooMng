<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 22/02/2015
 * Time: 20:13
 */

class AdminTableSeeder extends Seeder {

    /**
     *
     */
    public function run()
    {
        $faker = Faker::create();
        $id = \DB::table('users')->insertGetId( array(
            'name' => 'jose',
            'email' => 'jmgarciacarrasco@gmail.com',
            'password' => \Hash::make('tec_002!'),
            'type'=> 'admin'
        ) );

        /*\DB::table('user_profiles')->insert( array (
            'user_id'   => $id,
            'birth_date'=> $faker->dateTimeBetween('-65 years','-15 years')->format('Y-m-d'),
            'gender'    => 'male',
            'bio'       => $faker->paragraph(rand(1,4)),
            'phone'     => $faker->phoneNumber,
            'avatar'    => str_replace('http','https',$faker->imageUrl(64, 48)),

        ));*/

        
    }

}