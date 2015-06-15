<?php namespace App\Http\Middleware;

use Closure;

class Environment
{
	/**
	 * Ensure the app is running in the enviorment provided as parameter.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string
	 * @return mixed
	 */
	public function handle($request, Closure $next, $enviorment)
	{
		if (app()->environment($enviorment))
			return $next($request);

		return abort(404);
	}
}
