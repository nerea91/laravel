<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class SetupCountriesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'setup:countries';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup the countries that will be enabled';

	/**
	 * List of country codes/ids that will be enabled
	 *
	 * @var array
	 */
	protected $countries = [];

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// If no countries are provided ask for them interactively
		$this->countries = $this->argument('country') ?: $this->askCountries();

		// Check if all provided countries exist
		if ($unknownCountries = $this->getUnknownCountries())
			return $this->error('Invdalid countries: ' . implode(', ', $unknownCountries));

		// Disable all
		DB::table('countries')->update(['deleted_at' => '0000-00-00']);

		// Enable selected
		DB::table('countries')->whereIn('id', $this->countries)->orWhereIn('code', $this->countries)->update(['deleted_at' => null]);

		// to-do mostrar lista de los paises que han sido activados
	}

	/**
	 * Interactively ask the user to enter countries
	 *
	 * @return array
	 */
	public function askCountries()
	{
		return ['to-do askCountries'];
	}

	/**
	 * Return the codes/ids that don't belong to any country
	 *
	 * @return array
	 */
	public function getUnknownCountries()
	{
		return []; // to-do checkCountries
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('country', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Space separated list of country ids/codes to enable.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
