<?php namespace App\Console\Commands;

use App\Country;
use DB;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class SetupCountriesCommand extends Command
{
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
	 * List of all available countries
	 *
	 * @var Illuminate\Database\Eloquent\Collection
	 */
	protected $allCountries = [];

	/**
	 * List of country codes/ids that will be enabled
	 *
	 * @var array
	 */
	protected $selectedCountries = [];

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Check if there are any countries available
		$this->allCountries = $this->getCountries(true);
		if( ! $this->allCountries->count())
			return $this->error('No countries found. Did you seed the database?.');

		// If no countries are provided ask for them interactively
		$this->selectedCountries = $this->argument('country') ?: $this->askCountries();

		// Check if all provided countries exist
		if($unknownCountries = $this->getUnknownCountries())
			return $this->error('Invdalid countries: ' . PHP_EOL . implode(PHP_EOL, $unknownCountries));

		// Disable all
		DB::table('countries')->update(['deleted_at' => '0000-00-00']);

		// Enable selected
		DB::table('countries')->whereIn('id', $this->selectedCountries)->orWhereIn('iso_3166_2', $this->selectedCountries)->orWhereIn('iso_3166_3', $this->selectedCountries)->update(['deleted_at' => null]);

		// Show result
		$this->allCountries = $this->getCountries(false);
		$this->info('Enabled countries');
		$this->showCountriesList();
	}

	/**
	 * Fetch countries from database
	 *
	 * @param  bool
	 *
	 * @return Illuminate\Database\Eloquent\Collection (of Country)
	 */
	protected function getCountries($withTrashed)
	{
		$countries = Country::select('id', 'iso_3166_2', 'name')->orderBy('name');

		if($withTrashed)
			$countries->withTrashed();

		return $countries->get();
	}

	/**
	 * Show a list with all available countries
	 *
	 * @return void
	 */
	protected function showCountriesList()
	{
		$this->table(['Id', 'Code', 'Name'], $this->allCountries->toArray(), 'compact');
	}

	/**
	 * Interactively ask the user to enter countries
	 *
	 * @return array
	 */
	protected function askCountries()
	{
		$this->showCountriesList();
		$answer = $this->ask("Enter 'all' or a space separated list of ids/codes to enable: ");

		if(trim($answer) === 'all')
			return $this->allCountries->pluck('id')->all();

		// Filter input
		$answer = array_map('strtoupper', array_filter(array_map('trim', explode(' ', $answer))));

		// Loop until the user enters something
		if( ! $answer)
			return $this->askCountries();

		return $answer;
	}

	/**
	 * Return the codes/ids that don't belong to any country
	 *
	 * @return array
	 */
	protected function getUnknownCountries()
	{
		$unknown = $this->selectedCountries;

		foreach($this->allCountries as $country)
		{
			foreach (['id', 'iso_3166_2', 'iso_3166_3'] as $column)
			{
				// If there is a column match then the country is not unknown
				$key = array_search($country->$column, $unknown);
				if($key !== false)
				{
					unset($unknown[$key]);
					continue 2;
				}
			}
		}

		return $unknown;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['country', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Space separated list of country ids/codes to enable.'],
		];
	}
}
