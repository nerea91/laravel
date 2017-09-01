<?php namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use SSH;
use Symfony\Component\Console\Input\InputOption;

class SyncDatabaseMetaTablesCommand extends Command
{
	/**
	 * Tables that will be synced.
	 *
	 * @var array
	 */
	protected $tables = [
		// Table          => Primary key
		'options'         => 'name',
		'permissiontypes' => 'id',
		'permissions'     => 'id',
	];

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:sync';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sync meta tables with remote database server';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		// Get tables from command line
		$tables = ($tmp = $this->option('tables')) ? array_only($this->tables, explode(',', $tmp)) : $this->tables;
		if( ! $tables)
			return $this->error('You provide an invalid set of tables. Valid values are: ' . implode(',', array_keys($this->tables)));

		// Set verbosity
		$verbose = ($this->option('verbose') and ! $this->option('quiet'));

		// Connect to remote database
		$verbose and $this->comment('Connecting to remote database server');
		$connection = DB::connection('db:sync');

		// Loop tables looking for missing records
		$count = 0;
		foreach($tables as $table => $primaryKey)
		{
			$verbose and $this->comment("Comparing table '$table'");

			// Get existing records on local database
			$exisiting = (DB::table($table)->pluck($primaryKey)) ?: [ - 1];

			// Get new records on remote database
			$new = $connection->table($table)->whereNotIn($primaryKey, $exisiting)->get();

			// Insert new records
			foreach($new as $data)
			{
				$msg = sprintf('%s: %s', $table, $data->$primaryKey);

				if(DB::table($table)->insert((array) $data) and ++$count)
					$this->info($msg);
				else
					$this->error($msg);
			}
		}

		$verbose and $this->comment("Inserted $count new records");
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['tables', 't', InputOption::VALUE_REQUIRED, 'Comma separated list of tables to sync', implode(',', array_keys($this->tables))],
		];
	}
}
