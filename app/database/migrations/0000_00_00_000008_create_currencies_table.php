<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function (Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->increments('id');

			// Ordinary columns
			$table->string('code', 3)->unique();
			$table->string('name', 64);
			$table->string('name2', 64)->nullable();
			$table->string('symbol', 8)->nullable();
			$table->string('symbol2', 8)->nullable();
			$table->boolean('symbol_position')->unsigned()->default(1); // 0 left 1 right
			$table->string('decimal_separator', 1)->default('.');
			$table->string('thousands_separator', 1)->nullable();
			$table->string('subunit', 16)->nullable();
			$table->string('subunit2', 16)->nullable();
			$table->string('unicode_decimal', 32)->nullable();
			$table->string('unicode_hexadecimal', 16)->nullable();

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
		Schema::dropIfExists('currencies');
	}
}
