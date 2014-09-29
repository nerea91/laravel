<?php namespace App\Http\Filters;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class EnvironmentFilter
{
	/**
	 * This filter ensures the app is running in the enviorment provided as parameter.
	 *
	 * @param  \Illuminate\Routing\Route  $route
	 * @param  \Illuminate\Http\Request  $request
	 * @param  string
	 * @return mixed
	 */
	public function filter(Route $route, Request $request, $enviorment)
	{
		if ( ! app()->environment($enviorment))
			return app()->abort(404);
	}
}