<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GameViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_views', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status');
            $table->string('logo1')->nullable();
            $table->string('headerMain')->nullable();
            $table->string('headerSub')->nullable();
            $table->string('logo2')->nullable();
            $table->longText('body')->nullable();
            $table->integer('next')->nullable();
            $table->longText('messages');

            $table->integer('gameboard_id')->unsigned();
            $table->foreign('gameboard_id')
                ->references('id')
                ->on('gameboards')
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
        Schema::drop('game_views');
    }
}
