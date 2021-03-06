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
		'Illuminate\Auth\Events\Login' => [
			'App\Listeners\LogSuccessfulLogin',
		],

		'Illuminate\Auth\Events\Logout' => [
			'App\Listeners\LogSuccessfulLogout',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher $events
	 *
	 * @return void
	 */
	public function boot()
	{
		parent::boot();

		Event::listen('account.login', function ($account) {
			// Update IP address
			$account->last_ip = Request::getClientIp();
			$account->save();

			// Increment login count for the account ...
			$account->increment('login_count');

			// ... and for its auth provider
			$account->provider()->increment('login_count');
		});
	}
}
