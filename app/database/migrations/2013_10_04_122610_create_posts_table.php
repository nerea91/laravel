<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			//Primary key
			$table->increments('id');

			//Standar columns
			$table->string('title');
			$table->text('body');

			//Foreign keys
			$table->unsignedInteger('user_id');$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

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
		Schema::dropIfExists('posts');
	}

}
