<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Item extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('items', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->float('initial_price')->unsigned();
            $table->float('max_price')->unsigned()->nullable();
            $table->string('photo');
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
        Schema::drop('items');
	}

}
