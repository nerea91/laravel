<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class SetupCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup default values for several database tables';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Superuser
		if( ! $this->option('no-superuser'))
			$this->call('setup:superuser');

		// Countries
		if( ! $this->option('no-countries'))
			$this->call('setup:countries', ['country' => array_filter(explode(',', $this->option('countries')))]);

		// Languages
		if( ! $this->option('no-languages'))
			$this->call('setup:languages', ['language' => array_filter(explode(',', $this->option('languages')))]);

		// Currencies
		if( ! $this->option('no-currencies'))
			$this->call('setup:currencies', ['currency' => array_filter(explode(',', $this->option('currencies')))]);

		// Clear cache
		$this->call('cache:clear');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			//['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['countries', 'c', InputOption::VALUE_REQUIRED, 'Comma separated list of country ids/codes to enable.', null],
			['languages', 'l', InputOption::VALUE_REQUIRED, 'Comma separated list of language ids/codes to enable.', null],
			['currencies', 'x', InputOption::VALUE_REQUIRED, 'Comma separated list of currency ids/codes to enable.', null],
			['no-superuser', 's', InputOption::VALUE_NONE, 'Skip superuser password setup.', null],
			['no-countries', 'd', InputOption::VALUE_NONE, 'Skip countries setup.', null],
			['no-languages', 'm', InputOption::VALUE_NONE, 'Skip languages setup.', null],
			['no-currencies', 'z', InputOption::VALUE_NONE, 'Skip currencies setup.', null],
		];
	}
}
