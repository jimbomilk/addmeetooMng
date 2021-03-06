<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Location extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('locations', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');

            $table->integer('owner_id')->unsigned();
            $table->foreign('owner_id')
                ->references('id')
                ->on('users');

            $table->string('latitude');
            $table->string('longitude');
            $table->string('logo');
            $table->string('slogan');

            $table->string('street',    60);
            $table->string('city',      60);
            $table->string('state',     60);
            $table->string('post_code', 10);
            $table->integer('country_id')->unsigned()->index();
            $table->string('phone',    16);
            $table->string('email',    60);
            $table->string('website', 100);

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
		Schema::drop('locations');
	}

}
