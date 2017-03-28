<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GameboardOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gameboard_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order')->unsigned()->index();
            $table->longText('description');
            $table->integer('result')->default(-1); // este es el resultado del game si lo maneja el dueño del establecimiento
            $table->string('image');

            $table->integer('gameboard_id')->unsigned();
            $table->foreign('gameboard_id')
                ->references('id')
                ->on('gameboards')
                ->onDelete('cascade');


            $table->integer('activity_option_id')->unsigned();
            $table->foreign('activity_option_id')
                ->references('id')
                ->on('activity_options')
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
        Schema::drop('gameboard_options');
    }
}
