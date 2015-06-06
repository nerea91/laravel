<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// NOTE Insert here content of $this->crateNormalTable() or $this->createPivotTable() and then delete both functions along with $this->ordinaryColumns().
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('some_table');
	}

	// NOTE When you finish delete all functions below here, they are just boilerplate.

	/**
	 * Sample skeleton for creating a normal table.
	 *
	 * @return void
	 */
	public function crateNormalTable()
	{
		Schema::create('xxxs', function (Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->increments('id');// NOTE Alternative bigIncrements('id')

			// Ordinary columns
			// NOTE see $this->ordinaryColumns()

			// Foreign keys
			$table->unsignedInteger('zzz_id')->nullable();
			$table->foreign('zzz_id')->references('id')->on('zzzs')->onUpdate('cascade')->onDelete('cascade');

			// Extra keys
			$table->index('column', $name = null);
			$table->unique(array('foo', 'bar'));

			// Automatic columns
			$table->timestamps();// NOTE Alternative nullableTimestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Sample skeleton for creating a pivot table.
	 *
	 * @return void
	 */
	public function createPivotTable()
	{
		Schema::create('xxx_yyy', function (Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->increments('id');

			// Foreign keys
			$table->unsignedInteger('xxx_id');
			$table->foreign('xxx_id')->references('id')->on('xxxs')->onUpdate('cascade')->onDelete('cascade');

			$table->unsignedInteger('yyy_id');
			$table->foreign('yyy_id')->references('id')->on('yyys')->onUpdate('cascade')->onDelete('cascade');

			// Pivot columns
			// NOTE see $this->ordinaryColumns()

			// Extra keys
			$table->unique(['xxx_id', 'yyy_id']);

			// Automatic columns
			$table->timestamps();
		});
	}

	/**
	 * Sample for adding ordinary columns.
	 *
	 * @return void
	 */
	public function ordinaryColumns($table)
	{
		// Modifiers: ->unsigned()->nullable()->default($value)->unique()

		// Integers (Exact value)
		$table->boolean('column_name');
		$table->tinyInteger('column_name');
		$table->smallInteger('column_name');
		$table->mediumInteger('column_name');
		$table->integer('column_name');
		$table->unsignedInteger('column_name');
		$table->bigInteger('column_name');
		$table->unsignedBigInteger('column_name');

		// Fixed-point numbers (Exact value)
		$table->decimal('column_name', $totalDigits = 8, $decimalDigits = 2);

		// Floating-point numbers (Approximate value)
		$table->float('column_name', $totalDigits = 8, $decimalDigits = 2);
		$table->double('column_name', $totalDigits = null, $decimalDigits = null);

		// Text
		$table->char('column_name', $length = 255);
		$table->string('column_name', $length = 255);
		$table->text('column_name');
		$table->mediumText('column_name');
		$table->longText('column_name');

		// Date and Time
		$table->time('column_name');
		$table->timestamp('column_name');
		$table->date('column_name');
		$table->dateTime('column_name');
	}

	/* Other available methods pendding to add to this template:
	binary('column');
	dropColumn('column');
	dropForeign($index);
	dropIndex($index);
	dropPrimary($index = null)
	dropSoftDeletes();
	dropTimestamps();
	dropUnique($index);
	enum('choices', array('foo', 'bar'));
	getColumns();
	getCommands();
	getTable();
	morphs('taggable');	Adds INTEGER taggable_id and STRING taggable_type
	primary('string|array');
	rememberToken();	Adds remember_token as VARCHAR(100) NULL
	removeColumn($name);
	rename($to);
	renameColumn($from, $to);
	toSql(Connection $connection, Grammar $grammar);
	*/
}
