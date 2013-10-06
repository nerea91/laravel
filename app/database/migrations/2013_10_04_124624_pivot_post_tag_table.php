<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotPostTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_tag', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('post_id')->unsigned()->index();$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
			$table->integer('tag_id')->unsigned()->index();$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
			$table->unique(array('post_id', 'tag_id'));
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
		Schema::dropIfExists('post_tag');
	}

}
