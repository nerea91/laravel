<?php namespace App\Providers;

use App\Language;
use Cache;
use Event;
use Illuminate\Support\ServiceProvider;
use Request;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * Subscribe to several application events.
	 *
	 * @return void
	 */
	public function boot()
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
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
