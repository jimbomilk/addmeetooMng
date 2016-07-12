<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tvconfig extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('tvconfigs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->enum('state',['live','pause'])->default('pause');
            $table->integer('screen_timer')->unsigned(); //tiempo entre screen y screen

            $table->integer('location_id')->unsigned();
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
        Schema::drop('tvconfigs');
	}

}
