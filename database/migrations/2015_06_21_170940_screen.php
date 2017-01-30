<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Screen extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('screens', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('description');

            $table->string('latitude');
            $table->string('longitude');

            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')
                ->references('id')
                ->on('locations');

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
        Schema::drop('screens');
	}

}
