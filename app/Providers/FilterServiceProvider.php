<?php namespace App\Providers;

use Illuminate\Foundation\Support\Providers\FilterServiceProvider as ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{
	/**
	 * The filters that should run before all requests.
	 *
	 * @var array
	 */
	protected $before = [
		'App\Http\Filters\MaintenanceFilter',
	];

	/**
	 * The filters that should run after all requests.
	 *
	 * @var array
	 */
	protected $after = [
		//
	];

	/**
	 * All available route filters.
	 *
	 * @var array
	 */
	protected $filters = [
		'acl' => 'App\Http\Filters\AccessControlListFilter',
		'auth' => 'App\Http\Filters\AuthFilter',
		'auth.basic' => 'App\Http\Filters\BasicAuthFilter',
		'csrf' => 'App\Http\Filters\CsrfFilter',
		'env' => 'App\Http\Filters\EnvironmentFilter',
		'guest' => 'App\Http\Filters\GuestFilter',
		'tidy' => 'Stolz\Filters\HtmlTidy\Filter',
	];

	/**
	 * Register extra filters.
	 *
	 * @return void
	 */
	public function boot()
	{
		parent::boot();

		if($this->app->environment('local'))
			$this->app['router']->after('Stolz\Filters\HtmlTidy\Filter@globalFilter');
	}
}
