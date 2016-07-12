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

class AuctionTableSeeder extends Seeder
{

    /**
     *
     */

    

    public function run()
    {

        $faker = Faker::create();


        for ($i = 0; $i < 30; $i ++)
        {
            $iditem = \DB::table('items')->insertGetId( array(
                'name'          => $faker->word(),
                'description'   => $faker->text(200),
                'initial_price' => $faker->numberBetween(5,25),
                'max_price'     => $faker->numberBetween(50,100),
                'photo'         => $faker->imageUrl(64,48),

                'created_at' => \Carbon\Carbon::now()->toDateTimeString()
            ));

            $iduser = $faker->numberBetween(1,\DB::table('users')->count());

            $idlocation = $faker->numberBetween(1,\DB::table('locations')->count());

            $idbidder = \DB::table('bidders')->insertGetId( array(
                'user_id' => $iduser
            ));

            $highestPrice = 0;
            $winnerbid = null;
            for ($j = 0; $j < 5; $j ++)
            {

                $idbid = \DB::table('bids')->insertGetId(array(
                    'price' => $price = $faker->numberBetween(25, 100),
                    'bidder_id' => $idbidder,
                    'item_id' => $iditem,

                    'created_at' => \Carbon\Carbon::now()->toDateTimeString()

                ));
                if ($highestPrice<$price)
                {
                    $highestPrice = $price;
                    $winnerbid = $idbid;
                }
            }

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


            \DB::table('auctions')->insertGetId( array(
                'start'         => $start,
                'state'         => $status,
                'duration'      => $duration,
                'item_id'       => $iditem,
                'location_id'   => $idlocation,
                'winner_bid'    => ($status != 'ready'?$winnerbid:null),

                'created_at' => \Carbon\Carbon::now()->toDateTimeString()
            ));
        }
    }
};