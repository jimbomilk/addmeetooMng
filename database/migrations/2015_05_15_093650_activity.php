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
            $table->datetime('starttime')->nullable(); //fecha y hora de comienzo (dd/mm/yyyy hh:mm)
            $table->datetime('endtime')->nullable(); //fecha y hora del fin
            $table->datetime('deadline')->nullable(); // subscription deadline
            $table->enum('type',['vote','bet','game']); // tipo de actividad
            $table->enum('category',['sports','shopping','motor','party']); // where
            $table->boolean('head2head')->default(false);
            $table->integer('selection')->default(3);
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
