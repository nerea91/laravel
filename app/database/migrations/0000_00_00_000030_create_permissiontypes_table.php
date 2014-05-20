<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissiontypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissiontypes', function(Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->increments('id');

			// Ordinary columns
			$table->string('name', 64)->unique();
			$table->string('description')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('permissiontypes');
	}

}
