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

            $table->boolean('auto')->default(true); // Si es true significa que el juego se gestiona
            // automaticamente  desde la actividad. Si es false significa que el dueño del
            // establecimiento lo gestionará por si mismo.

            $table->time('starttime')->nullable(); //fecha y hora de comienzo de la actividad
            $table->integer('duration')->nullable();    // en minutos
            $table->dateTime('deadline')->nullable(); // si n es 0 significa que se puede participar todo el tiempo
            //                          Si es n>0  significa que desde q empieza la actividad hay n minutos para participar
            $table->dateTime('endgame')->nullable(); // cuando termina el juego.
            $table->integer('selection')->nullable();; // Cuantos hay q elegir

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