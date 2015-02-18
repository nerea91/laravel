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
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);

		// Register application global language
		if( ! $this->app->runningInConsole())
			$this->registerAppLanguage();
	}

	/**
	 * Register application global language.
	 *
	 * @return void
	 */
	protected function registerAppLanguage()
	{
		// Bind language to the IoC container
		$this->app->singleton('language', function () {

			$language = \App\Language::detect()->apply();

			// Write the result to the log
			if(config('app.debug'))
				info($language .' detected from ' . $language->detectedFrom);

			return $language;
		});
	}
}
