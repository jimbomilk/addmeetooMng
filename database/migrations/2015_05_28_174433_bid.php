<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bid extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('bids', function(Blueprint $table)
        {
            $table->increments('id');
            $table->float('price')->unsigned();

            $table->integer('bidder_id')->unsigned();
            $table->foreign('bidder_id')
                ->references('id')
                ->on('bidders')
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
        Schema::drop('bids');
	}

}
