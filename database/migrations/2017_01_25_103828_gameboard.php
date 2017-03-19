<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Status;

class Gameboard extends Migration
{
    /**
     * Tableros de Juego:
     *
     *  El administrador de un area debe crear sus propios juegos. Y lo primero es definir el tablero.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gameboards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('starttime')->nullable();  //fecha y hora de comienzo
            $table->dateTime('endtime')->nullable();    //fecha y hora del fin
            $table->integer('deadline')->default(0);// 0 significa que desde q empieza la actividad no se puede jugar.
                                                    // Si es positivo (+30) significa que 30 minutos despues de iniciarse la actividad se podria jugar
                                                    // Si es negativo (-30) significa que 30 minutos antes se cierran las inscripciones
            $table->integer('selection');

            // progression_type: define como va evolucionando el juego y sus pantallas.
            // Por ejemplo en una votacion son ordenadas, en un juego tipo gymkana son por usuario
            // y en otro tipo de juego pueden ser aleatorias.
            $table->enum('progression_type',['ordered','random']);
            $table->boolean('multiscreen'); //si true siginifica que tenemos que pintar cosas diferentes en cada screen dependiendiendo de la progression del usuario.
            $table->text('ranking');
            $table->string('status')->default(Status::CREATED);

            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')
                ->references('id')
                ->on('activities');

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
        Schema::drop('gameboards');
    }
}
