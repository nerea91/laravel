<?php namespace App\Providers;

use App\Language;
use DB;
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
		// Set application language
		$this->setApplicationLanguage();

		// Register our custom validator
		Validator::resolver(function ($translator, $data, $rules, $messages) {
			return new CustomValidator($translator, $data, $rules, $messages);
		});

		// Enable database strict mode if we are using MySQL in the local environment
		if($this->app->environment('local') and DB::connection()->getConfig('driver') === 'mysql')
			DB::statement('SET SESSION sql_mode="STRICT_ALL_TABLES"');
	}

	/**
	 * Set application global language.
	 *
	 * @return void
	 */
	protected function setApplicationLanguage()
	{
		if( ! $this->app->runningInConsole() or $this->app->environment('testing'))
		{
			$this->app->singleton('language', function () {
				// Detect language
				$language = Language::detect();

				// Write the result to the log
				if(config('app.debug'))
					info($language .' detected from ' . $language->detectedFrom);

				// Bind language to the IoC container
				return $language;
			});

			// Apply once the application has booted
			$this->app->booted(function() {
				$this->app->make('language')->apply();
			});
		}
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
