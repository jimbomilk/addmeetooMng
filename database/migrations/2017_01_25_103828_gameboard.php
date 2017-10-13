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

            $table->boolean('auto')->default(false); // Si es true significa que el juego no tiene opciones propias sino que son las propias de la actividad
            $table->dateTime('deadline')->nullable();   // fecha y hora de fin de participación
            $table->dateTime('startgame')->nullable();  // cuando empieza el juego.
            $table->dateTime('endgame')->nullable();    // cuando termina el juego.
            $table->integer('selection')->nullable();;  // Cuantos hay q elegir

            // progression_type: define como va evolucionando el juego y sus pantallas.
            // Por ejemplo en una votacion son ordenadas, en un juego tipo gymkana son por usuario
            // y en otro tipo de juego pueden ser aleatorias.
            $table->enum('progression_type',['ordered','random'])->default('ordered')->nullable();
            $table->boolean('multiscreen')->default(false); //si true siginifica que tenemos que pintar cosas diferentes en cada screen dependiendiendo de la progression del usuario.
            $table->integer('status')->default(Status::DISABLED);

            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')
                ->references('id')
                ->on('activities')
                ->onDelete('cascade');

            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');

            $table->string('image')->nullable();
            $table->string('imagebig')->nullable();

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
