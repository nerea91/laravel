<?php namespace App\Console\Commands;

use App\Currency;
use DB;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class SetupCurrenciesCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'setup:currencies';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup the currencies that will be enabled';

	/**
	 * List of all available currencies
	 *
	 * @var Illuminate\Database\Eloquent\Collection
	 */
	protected $allCurrencies;

	/**
	 * List of currency codes/ids that will be enabled
	 *
	 * @var array
	 */
	protected $selectedCurrencies = [];

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		// Check if there are any currencies available
		$this->allCurrencies = $this->getCurrencies(true);
		if( ! $this->allCurrencies->count())
			return $this->error('No currencies found. Did you seed the database?.');

		// If no currencies are provided ask for them interactively
		$this->selectedCurrencies = $this->argument('currency') ?: $this->askCurrencies();

		// Check if all provided currencies exist
		if($unknownCurrencies = $this->getUnknownCurrencies())
			return $this->error('Invdalid currencies: ' . PHP_EOL . implode(PHP_EOL, $unknownCurrencies));

		// Disable all
		DB::table('currencies')->update(['deleted_at' => '0000-00-00']);

		// Enable selected
		DB::table('currencies')->whereIn('id', $this->selectedCurrencies)->orWhereIn('code', $this->selectedCurrencies)->update(['deleted_at' => null]);

		// Show result
		$this->allCurrencies = $this->getCurrencies(false);
		$this->info('Enabled currencies');
		$this->showCurrenciesList();
	}

	/**
	 * Fetch currencies from database
	 *
	 * @param  bool
	 *
	 * @return Illuminate\Database\Eloquent\Collection (of Currency)
	 */
	protected function getCurrencies($withTrashed)
	{
		$currencies = Currency::select('id', 'code', 'name')->orderBy('name');

		if($withTrashed)
			$currencies->withTrashed();

		return $currencies->get();
	}

	/**
	 * Show a list with all available currencies
	 *
	 * @return void
	 */
	protected function showCurrenciesList()
	{
		$this->table(['Id', 'Code', 'Name'], $this->allCurrencies->toArray(), 'compact');
	}

	/**
	 * Interactively ask the user to enter currencies
	 *
	 * @return array
	 */
	protected function askCurrencies()
	{
		$this->showCurrenciesList();
		$answer = $this->ask("Enter 'all' or a space separated list of ids/codes to enable: ");

		if(trim($answer) === 'all')
			return $this->allCurrencies->pluck('id')->all();

		// Filter input
		$answer = array_map('strtoupper', array_filter(array_map('trim', explode(' ', $answer))));


		// Loop until the user enters something
		if( ! $answer)
			return $this->askCurrencies();

		return $answer;
	}

	/**
	 * Return the codes/ids that don't belong to any currency
	 *
	 * @return array
	 */
	protected function getUnknownCurrencies()
	{
		$unknown = $this->selectedCurrencies;

		foreach($this->allCurrencies as $currency)
		{
			foreach (['id', 'code'] as $column)
			{
				// If there is a column match then the currency is not unknown
				$key = array_search($currency->$column, $unknown);
				if ($key !== false)
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
			['currency', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Space separated list of currency ids/codes to enable.'],
		];
	}
}
