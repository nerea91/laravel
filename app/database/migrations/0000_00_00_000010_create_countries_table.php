<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 64)->unique();
			$table->string('full_name', 128)->nullable()->unique();
			$table->string('iso_3166_2', 2)->unique();
			$table->string('iso_3166_3', 3)->unique();
			$table->string('country_code', 3)->unique();
			$table->string('capital', 64)->nullable();
			$table->string('citizenship', 64)->nullable();
			$table->string('currency', 64)->nullable();
			$table->string('currency_code', 16)->nullable();
			$table->string('currency_sub_unit', 32)->nullable();
			$table->string('region_code', 3)->nullable();
			$table->string('sub_region_code', 3)->nullable();
			$table->boolean('eea')->unsigned()->default(0); //European Economic Area

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
		Schema::dropIfExists('countries');
	}

}

