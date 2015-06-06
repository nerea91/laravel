<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function (Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->increments('id');

			// Ordinary columns
			$table->string('uid', 128); //user unique id in the remote provider
			$table->text('access_token')->nullable();
			$table->string('nickname', 128)->nullable();
			$table->string('email')->nullable();
			$table->string('name', 128)->nullable();
			$table->string('first_name', 64)->nullable();
			$table->string('last_name', 64)->nullable();
			$table->string('image')->nullable();
			$table->string('locale', 5)->nullable();
			$table->string('location', 128)->nullable();
			$table->unsignedInteger('login_count')->default(0);
			$table->text('last_ip')->nullable();

			// Foreign keys
			$table->unsignedInteger('provider_id');
			$table->foreign('provider_id')->references('id')->on('authproviders')->onUpdate('cascade')->onDelete('cascade');
			
			$table->unsignedInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

			// Extra keys
			$table->unique(['provider_id', 'uid']);
			$table->unique(['provider_id', 'user_id']);

			// Automatic columns
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
		Schema::dropIfExists('accounts');
	}
}
