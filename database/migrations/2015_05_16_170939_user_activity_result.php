<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserActivityResult extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_activity_results', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id');
            $table->integer('activity_id');
            $table->dateTime('startTime');
            $table->dateTime('endTime');
            $table->integer('points');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_activity_results');
	}

}
