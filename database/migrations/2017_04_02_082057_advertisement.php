<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Advertisement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('imagebig')->nullable();
            $table->string('imagesmall')->nullable();
            $table->string('textsmall1')->nullable();
            $table->string('textsmall2')->nullable();
            $table->string('textbig1')->nullable();
            $table->longText('textbig2')->nullable();

            $table->integer('adscategory_id')->unsigned();
            $table->foreign('adscategory_id')
                ->references('id')
                ->on('adscategories')
                ->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('advertisements');
    }
}
