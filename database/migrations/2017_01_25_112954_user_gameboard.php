<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserGameboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gameboards', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('points')->default(0);
            $table->integer('temp_points')->default(0);
            $table->integer('rank')->default(0);
            $table->integer('rankpo')->default(0);
            $table->string('pushId')->nullable();
            $table->string('pushToken')->nullable();

            $table->integer('gameboard_id')->unsigned();
            $table->foreign('gameboard_id')
                ->references('id')
                ->on('gameboards')
                ->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->binary('progression'); // json de la progressión para los game.
            $table->longText('values'); // json de opciones [{opcion1:value},{opcion2:value}...]

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
        Schema::drop('user_gameboards');
    }
}
