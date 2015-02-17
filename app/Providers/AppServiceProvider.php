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

		// to-do esto deberia ir en EventServiceProvider, pero no he tenido tiempo de migrarlo a laravel5
		$this->registerEventListeners();
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

			$language = \App\Language::detect();

			// Write the result to the log
			if(config('app.debug'))
				info($language .' detected from ' . $language->detectedFrom);

			return $language;
		});

		// Apply once the application has booted
		$this->app->booted(function() {
			$this->app->make('language')->apply();
		});
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
}
