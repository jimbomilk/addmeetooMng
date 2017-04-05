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

            $table->string('logo');
            $table->string('slogan');

            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('countries_id')->unsigned()->index();
            $table->foreign('countries_id')
                ->references('id')
                ->on('countries');
            $table->string('phone',    16);
            $table->string('email',    60);
            $table->string('website', 100);
            $table->string('timezone')->default('Europe/Madrid');
            $table->enum('category',array('restaurant','bar','cinema','shopping','sports','karaoke','museum','party'));

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
