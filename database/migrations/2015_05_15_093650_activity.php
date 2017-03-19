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

            $table->dateTime('starttime')->nullable();
            $table->dateTime('endtime')->nullable();
            $table->integer('deadline')->default(0);// Si es 0 significa que desde q empieza la actividad no se puede inscribir nadie.
                                                    // Si es positivo (+30) significa que 30 minutos despues de iniciarse la actividad se podria jugar
                                                    // Si es negativo (-30) significa que 30 minutos antes se cierran las inscripciones
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
