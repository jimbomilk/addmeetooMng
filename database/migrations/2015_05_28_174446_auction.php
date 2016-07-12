<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Auction extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('auctions', function(Blueprint $table)
        {
            $table->increments('id');


            $table->enum('state',['ready','running','cancelled','finished'])->default('ready');
            $table->datetime('start')->nullable(); //fecha y hora de comienzo (dd/mm/yyyy hh:mm)
            $table->integer('duration')->unsigned(); //duracion en minutes

            $table->integer('winner_bid')->nullable()->unsigned(); //winner bid

            $table->integer('location_id')->nullable()->unsigned(); //location: cada subasta es de una tienda diferente
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');

            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')
                ->references('id')
                ->on('items')
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
        Schema::drop('auctions');
	}

}
