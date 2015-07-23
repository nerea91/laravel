<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		//
	];

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Apply global language
		app('language')->apply();
		// NOTE:
		// This code was originally in AppServideProvider boot() method but since Laravel 5 does not work. I tried moving
		// it to a custom middleware but it has no effect. The only place that seems to have effect is in the Csrf middleware.

		return parent::handle($request, $next);
	}
}
