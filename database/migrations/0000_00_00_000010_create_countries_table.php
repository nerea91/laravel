<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function (Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->increments('id');

			// Ordinary columns
			$table->string('name', 64)->unique();
			$table->string('full_name', 128)->nullable()->unique();
			$table->string('iso_3166_2', 2)->unique();
			$table->string('iso_3166_3', 3)->unique();
			$table->string('code', 3)->unique();
			$table->string('capital', 64)->nullable();
			$table->string('citizenship', 64)->nullable();
			$table->string('region', 3)->nullable();
			$table->string('subregion', 3)->nullable();
			$table->boolean('eea')->unsigned()->default(0); //European Economic Area

			// Foreign keys
			$table->unsignedInteger('currency_id')->nullable();
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('set null');

			// Automatic columns
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
