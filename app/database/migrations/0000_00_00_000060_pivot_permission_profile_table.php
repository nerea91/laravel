<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotPermissionProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permission_profile', function(Blueprint $table) {
			$table->increments('id');

			//Foreign keys
			$table->unsignedInteger('permission_id');$table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('cascade')->onDelete('cascade');
			$table->unsignedInteger('profile_id');$table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');
			$table->unique(array('permission_id', 'profile_id'));

			//Automatic columns
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
		Schema::dropIfExists('permission_profile');
	}

}
