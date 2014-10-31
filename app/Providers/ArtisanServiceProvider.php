<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ArtisanServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->commands([
			'App\Console\DeployCommand',
			'App\Console\GettextCommand',
			'App\Console\SetupCommand',
			'App\Console\SetupCountriesCommand',
			'App\Console\SetupCurrenciesCommand',
			'App\Console\SetupLanguagesCommand',
			'App\Console\SetupSuperUserCommand',
			'App\Console\SyncDatabaseMetaTablesCommand',
		]);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['App\Console\InspireCommand'];
	}
}
