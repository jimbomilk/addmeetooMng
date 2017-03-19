<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityOption extends Migration
{
    /**
     * Entidad para guardar las opciones genericas de una actividad
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order')->unsigned()->index();
            $table->longText('description');
            $table->string('image');


            $table->integer('result')->default(-1); // sólo aplicable para los resultados de las apuestas.

            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')
                ->references('id')
                ->on('activities')
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
        Schema::drop('activity_options');
    }
}
