<?php namespace App\Providers;

use App\Validation\Validator as CustomValidator;
use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// keep url in plural
		Route::singularResourceParameters(false);

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
		// Load environment Specific Service Providers...
		switch($this->app->environment())
		{
			default:
				$providers = [];
				break;

			case 'local':
				$providers = [
					'Barryvdh\Debugbar\ServiceProvider',
					'Stolz\HtmlTidy\ServiceProvider',
					'Stolz\SchemaSpy\ServiceProvider',
				];
				break;

			case 'testing':
				$providers = [
					'Stolz\HtmlTidy\ServiceProvider',
				];
				break;
		}

		foreach($providers as $provider)
			$this->app->register($provider);
	}
}
