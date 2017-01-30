<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        $this->truncateTables();

		$this->call('AdminTableSeeder');
		$this->call('UserTableSeeder');
        $this->call('ActivityTableSeeder');
        $this->call('AuctionTableSeeder');

	}

    public function truncateTables()
    {
        $tables = array(
                'user_gameboard_options',
                'user_gameboards',
                'gameboard_options',
                'gameboards',
                'activity_options',
                'activities',
                'auctions',
                'bidders',
                'bids',
                'items',
                'languages',
                'locations',
                'password_resets',
                'screens',
                'users',
                'user_profiles',
        );

        $this->dbForeign(false);
        foreach ($tables as $table)
        {
            \Illuminate\Support\Facades\DB::table($table)->truncate();
        }

        $this->dbForeign(true);
    }

    public function dbForeign($activate)
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = ' . ($activate? '1':'0'));
    }

}
