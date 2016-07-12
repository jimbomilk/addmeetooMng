<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Activity extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activities', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name',100);

            $table->longText('description');
            $table->enum('state',['ready','running','cancelled','finished'])->default('ready');
            $table->datetime('start')->nullable(); //fecha y hora de comienzo (dd/mm/yyyy hh:mm)

            $table->datetime('ending')->nullable(); //finish time en minutes

            $table->enum('grouping',['one','pairs','trios']); // one, pairs, trios...
            $table->enum('selection',['random','best']); // randon , best
            $table->enum('point_system',['bypoints','bytime']); // by points or by time
            $table->enum('how',['byposition','bypairing']); // position control or NFC pairing
            $table->integer('category_id')->unsigned(); // where
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->integer('location_id')->unsigned(); // where
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');


            $table->integer('location_position_id')->unsigned(); // where
            $table->foreign('location_position_id')
                ->references('id')
                ->on('location_positions')
                ->onDelete('cascade');


            $table->integer('duration')->unsigned(); // in minutes
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
		Schema::drop('activities');
	}

}
