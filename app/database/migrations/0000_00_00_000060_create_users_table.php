<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('email')->nullable()->unique();
			$table->integer('age')->nullable();

			//Foreign keys
			$table->unsignedInteger('country_id')->nullable();$table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('restrict');

			//Automatic columns
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}

}
