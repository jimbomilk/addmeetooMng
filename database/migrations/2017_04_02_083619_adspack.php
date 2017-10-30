<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Adspack extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adspacks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bigpack')->unsigned()->default(0);
            $table->integer('smallpack')->unsigned()->default(0);
            $table->integer('bigdisplayed')->unsigned()->default(0);
            $table->integer('smalldisplayed')->unsigned()->default(0);

            $table->dateTime('startdate')->nullable();
            $table->dateTime('enddate')->nullable();

            $table->integer('advertisement_id')->unsigned();
            $table->foreign('advertisement_id')
                ->references('id')
                ->on('advertisements')
                ->onDelete('cascade');

            //Where
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('address')->nullable();
            $table->integer('radio')->unsigned()->default(25);
            
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
        Schema::drop('adspacks');
    }
}
