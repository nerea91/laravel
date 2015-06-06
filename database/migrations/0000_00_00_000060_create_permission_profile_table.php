<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionProfileTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permission_profile', function (Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->increments('id');

			// Foreign keys
			$table->unsignedInteger('permission_id');
			$table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('cascade')->onDelete('cascade');
			
			$table->unsignedInteger('profile_id');
			$table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

			// Pivot columns

			// Extra keys
			$table->unique(['permission_id', 'profile_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('permission_profile');
	}
}
