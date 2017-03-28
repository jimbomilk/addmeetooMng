<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserProfile extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_profiles', function(Blueprint $table)
		{
			$table->increments('id');
            $table->mediumText('bio')->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['male','female']);
            $table->string('avatar')->nullable();
            $table->integer('points')->default(0);
            $table->integer('rank_city')->default(0);
            $table->integer('rank_national')->default(0);
            $table->integer('rank_world')->default(0);

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
			            ->references('id')
			            ->on('users')
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
		Schema::drop('user_profiles');
	}

}
