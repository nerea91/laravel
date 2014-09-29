<?php namespace App\Providers;

use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
	/**
	 * Configure the application's logging facilities.
	 *
	 * @return void
	 */
	public function boot(Log $log)
	{
		$log->useFiles(storage_path().'/logs/laravel.log');

		// Add FirePHP Handler to Monolog
		//Log::getMonolog()->pushHandler(new \Monolog\Handler\FirePHPHandler());
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
