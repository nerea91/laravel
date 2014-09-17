<?php namespace App\Providers;

use App\Language;
use Illuminate\Support\ServiceProvider;
use Validator;
use App\Validation\Validator as CustomValidator;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any necessary services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Set application language and bind it to the IoC container.
		if( ! $this->app->runningInConsole() or $this->app->environment('testing'))
		{
			$this->app->singleton('language', function () {
				return Language::detect()->apply();
			});
		}

		// Register our custom validator
		Validator::resolver(function ($translator, $data, $rules, $messages) {
			return new CustomValidator($translator, $data, $rules, $messages);
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your services
		// in the IoC container. If you wish, you may make additional methods
		// or service providers to keep the code more focused and granular.
	}
}
