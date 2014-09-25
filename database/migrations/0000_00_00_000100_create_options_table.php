<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('options', function (Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id')->primary(); // We need full control of the ID so no autoincrement here!!

			// Ordinary columns
			$table->string('name', 32)->unique();
			$table->string('label', 64)->unique();
			$table->string('description', 128)->nullable();
			$table->string('value', 64);
			$table->boolean('assignable')->default(1);
			$table->string('validation_rules', 255);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('options');
	}
}
