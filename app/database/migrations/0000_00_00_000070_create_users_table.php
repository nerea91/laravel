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
		//--fields="username:string[64]:unique,name:string[64]:nullable,password:string[60],country_id:unsignedInteger:nullable,profile_id:unsignedInteger"
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('username', 32)->unique();
			$table->string('name', 64)->nullable();
			$table->string('description', 128)->nullable();
			$table->string('password', 60);

			//Foreign keys
			$table->unsignedInteger('country_id')->nullable();$table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('set null');
			$table->unsignedInteger('language_id')->nullable();$table->foreign('language_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('set null');
			$table->unsignedInteger('profile_id');$table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('restrict');

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
