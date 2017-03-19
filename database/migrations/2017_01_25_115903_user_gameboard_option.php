<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserGameboardOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gameboard_options', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_gameboard_id')->unsigned();
            $table->foreign('user_gameboard_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('value');
            $table->enum('status',['locked','open','closed']);

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
        Schema::drop('user_gameboard_options');
    }
}
