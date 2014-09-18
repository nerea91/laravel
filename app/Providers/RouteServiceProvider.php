<?php namespace App\Providers;

use Illuminate\Routing\RouteServiceProvider as ServiceProvider;
use URL;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * Called before routes are registered.
	 *
	 * Register any model bindings or pattern based filters.
	 *
	 * @return void
	 */
	public function before()
	{
		URL::setRootControllerNamespace(
			trim(config('namespaces.controller'), '\\')
		);
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{
		app()->booted(function() {
			// Once the application has booted, we will include the default routes
			// file. This "namespace" helper will load the routes file within a
			// route group which automatically sets the controller namespace.
			$this->namespaced(function() {
				require app_path().'/Http/routes.php';
			});
		});
	}
}
