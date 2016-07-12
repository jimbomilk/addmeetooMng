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
        $this->call('TvTableSeeder');
        $this->call('PersonTableSeeder');
        
	}

    public function truncateTables()
    {
        $tables = array(
                'activities',
                'auctions',
                'bidders',
                'bids',
                'categories',
                'category_features',
                'descriptions',
                'items',
                'languages',
                'locations',
                'location_positions' ,
                'password_resets',
                'screens',
                'tvconfigs',
                'users',
                'user_activities',
                'user_activity_results',
                'user_profiles',
                'persons',
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
