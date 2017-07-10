<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class Message extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('messages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('stext')->nullable();
            $table->text('ltext')->nullable();
            $table->text('image');
            $table->dateTime('start');
            $table->dateTime('end');


            $table->enum('type',['trabajo','ocio','util']);

            $table->integer('location_id')->unsigned()->nullable(); // Si no tiene location son avisos generales
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');

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
        Schema::drop('messages');
	}

}
