<?php namespace App\Providers;

use App\Language;
use App\Validation\Validator as CustomValidator;
use Cache;
use DB;
use Event;
use Illuminate\Support\ServiceProvider;
use Request;
use Validator;

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

		// to-do esto deberia ir en EventServiceProvider, pero no he tenido tiempo de migrarlo a laravel5
		$this->registerEventListeners();
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
				/*if(config('app.debug'))
					info($language .' detected from ' . $language->detectedFrom);*/

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
	 * to-do esto deberia ir en EventServiceProvider, pero no he tenido tiempo de migrarlo a laravel5
	 *
	 * @return void
	 */
	protected function registerEventListeners()
	{
		Event::listen('account.login', function ($account) {
			// Update IP address
			$account->last_ip = Request::getClientIp();
			$account->save();

			// Increment login count for the account ...
			$account->increment('login_count');

			// ... and for its auth provider
			$account->provider()->increment('login_count');
		});

		Event::listen('auth.login', function ($user) {
			// Change application language to current user's language
			$user->applyLanguage();
		});

		Event::listen('auth.logout', function ($user) {
			// Reset default application language
			Language::forget();

			// Purge admin panel search results cache
			Cache::forget('adminSearchResults' . $user->getKey());
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
