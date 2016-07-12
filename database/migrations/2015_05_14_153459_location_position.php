<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LocationPosition extends Migration {

    public function up()
    {
        Schema::create('location_positions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('description');
            $table->integer('barcode');
            $table->integer('location_id')->unsigned();
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
        Schema::drop('location_positions');
    }

}
