<?php namespace App\Console\Commands;

use App\Language;
use DB;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class SetupLanguagesCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'setup:languages';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup the languages that will be enabled';

	/**
	 * List of all available languages
	 *
	 * @var Illuminate\Database\Eloquent\Collection
	 */
	protected $allLanguages = [];

	/**
	 * List of language codes/ids that will be enabled
	 *
	 * @var array
	 */
	protected $selectedLanguages = [];

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Check if there are any languages available
		$this->allLanguages = $this->getLanguages(true);
		if( ! $this->allLanguages->count())
			return $this->error('No languages found. Did you seed the database?.');

		// If no languages are provided ask for them interactively
		$this->selectedLanguages = $this->argument('language') ?: $this->askLanguages();

		// Check if all provided languages exist
		if($unknownLanguages = $this->getUnknownLanguages())
			return $this->error('Invdalid languages: ' . PHP_EOL . implode(PHP_EOL, $unknownLanguages));

		// Disable all
		DB::table('languages')->update(['is_default' => 0, 'deleted_at' => '0000-00-00']);

		// Enable selected
		DB::table('languages')->whereIn('id', $this->selectedLanguages)->orWhereIn('code', $this->selectedLanguages)->update(['deleted_at' => null]);

		// Set default
		DB::table('languages')->where('id', $this->selectedLanguages[0])->orWhere('code', $this->selectedLanguages[0])->limit(1)->update(['is_default' => 1]);

		// Show result
		$this->allLanguages = $this->getLanguages(false);
		$this->info('Enabled languages');
		$this->showLanguagesList();
	}

	/**
	 * Fetch languages from database
	 *
	 * @param  bool
	 *
	 * @return Illuminate\Database\Eloquent\Collection (of Language)
	 */
	protected function getLanguages($withTrashed)
	{
		$languages = Language::select('id', 'code', 'is_default', 'name')->orderBy('is_default', 'desc')->orderBy('name');

		if($withTrashed)
			$languages->withTrashed();

		return $languages->get();
	}

	/**
	 * Show a list with all available languages
	 *
	 * @return void
	 */
	protected function showLanguagesList()
	{
		$this->table(['Id', 'Code', 'Default', 'Name'], $this->allLanguages->toArray(), 'compact');
	}

	/**
	 * Interactively ask the user to enter languages
	 *
	 * @return array
	 */
	protected function askLanguages()
	{
		$this->showLanguagesList();
		$answer = $this->ask('Enter a space separated list of ids/codes to enable (the first one will become the default)');

		// Filter input
		$answer = array_map('strtolower', array_filter(array_map('trim', explode(' ', $answer))));

		// Loop until the user enters something
		return ($answer) ?: $this->askLanguages();
	}

	/**
	 * Return the codes/ids that don't belong to any language
	 *
	 * @return array
	 */
	protected function getUnknownLanguages()
	{
		$unknown = $this->selectedLanguages;

		foreach($this->allLanguages as $language)
		{
			foreach(['id', 'code'] as $column)
			{
				// If there is a column match then the language is not unknown
				$key = array_search($language->$column, $unknown);
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
			['language', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Space separated list of language ids/codes to enable.'],
		];
	}
}
