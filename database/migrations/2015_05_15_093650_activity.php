<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Activity extends Migration {

	/**
	 * Activity : generic activity defining the basic information required to make new activities
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
            $table->enum('type',['vote','bet','game']); // tipo de actividad
            $table->enum('category',['calidad de vida','orgullo','deporte','niños','fiesta','cultura','salud','trabajo']); // category
            $table->boolean('head2head')->default(false);
            $table->integer('selection')->default(3);
            $table->integer('reward_participation')->default(50);

            $table->boolean('reward')->default(true);
            $table->integer('reward_first')->default(1000);
            $table->integer('reward_second')->default(500);
            $table->integer('reward_third')->default(200);

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
