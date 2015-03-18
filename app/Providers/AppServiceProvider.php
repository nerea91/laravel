<?php namespace App\Providers;

use App\Validation\Validator as CustomValidator;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Apply global language
		//app('language')->apply(); NOTE: Moved to a middleware since Laravel 5 is broken and calling this here has no effect anymore

		// Register our custom validator
		Validator::resolver(function ($translator, $data, $rules, $messages) {
			return new CustomValidator($translator, $data, $rules, $messages);
		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		// Detect global language
		$this->app->singleton('language', function () {

			return \App\Language::detect();
		});

		// Load environment Specific Service Providers...
		if($this->app->environment('local'))
		{
			$providers = [
				'Barryvdh\Debugbar\ServiceProvider',
				'Stolz\HtmlTidy\ServiceProvider',
				'Stolz\SchemaSpy\ServiceProvider',
			];

			foreach($providers as $provider)
				$this->app->register($provider);
		}
	}
}
