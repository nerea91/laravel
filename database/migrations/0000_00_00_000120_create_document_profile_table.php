<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentProfileTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('document_profile', function (Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->increments('id');

			// Foreign keys
			$table->unsignedInteger('document_id');
			$table->foreign('document_id')->references('id')->on('documents')->onUpdate('cascade')->onDelete('cascade');
			
			$table->unsignedInteger('profile_id');
			$table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

			// Extra keys
			$table->unique(['document_id', 'profile_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('document_profile');
	}
}
