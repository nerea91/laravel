<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ArtisanServiceProvider extends ServiceProvider
{
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
			'App\Console\InspireCommand',
			'App\Console\SetupCommand',
			'App\Console\SetupCountriesCommand',
			'App\Console\SetupCurrenciesCommand',
			'App\Console\SetupLanguagesCommand',
			'App\Console\SetupSuperUserCommand',
		]);
	}
}
