<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('languages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('code', 2)->unique();
			$table->string('name', 32)->unique();
			$table->string('english_name', 32)->unique();
			$table->string('locale', 5);
			$table->boolean('is_default')->unsigned()->default(0);
			$table->integer('priority');

			//Automatic columns
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
		Schema::dropIfExists('languages');
	}

}
