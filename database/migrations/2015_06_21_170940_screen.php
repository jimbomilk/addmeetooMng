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
            $table->string('name');
            $table->integer('order')->unsigned();
            
            $table->enum('type',['top_rank','activity_rank','messages','advertisement']);

            $table->enum('state',['on','off'])->default('on');

            $table->string('ad_text')->nullable();
            $table->string('ad_img')->nullable();

            $table->integer('activity_id')->unsigned()->nullable();
            $table->foreign('activity_id')
                ->references('id')
                ->on('activities');


            $table->integer('tvconfig_id')->unsigned();
            $table->foreign('tvconfig_id')
                ->references('id')
                ->on('tvconfigs');
			
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
