<?php namespace App\Providers;

use App\Language;
use Cache;
use Event;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Request;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'event.name' => [
			'EventListener',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

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
