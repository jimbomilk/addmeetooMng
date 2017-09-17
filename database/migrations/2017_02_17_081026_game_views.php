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
            $table->string('image')->nullable();
            $table->longText('body')->nullable();
            $table->longText('stats')->nullable();
            $table->string('type')->nullable();
            $table->string('code')->nullable();
            $table->dateTime('startgame')->nullable(); //fecha y hora de comienzo de la actividad
            $table->dateTime('endgame')->nullable();    // en minutos
            $table->dateTime('deadline')->nullable(); // fecha tope de participacion.
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
