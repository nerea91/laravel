<?php namespace App\Http\Filters;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Response;

class AuthFilter
{
	/**
	 * Run the request filter.
	 *
	 * @param  \Illuminate\Routing\Route  $route
	 * @param  \Illuminate\Http\Request  $request
	 * @return mixed
	 */
	public function filter(Route $route, Request $request)
	{
		if (Auth::guest())
		{
			if ($request->ajax())
			{
				return Response::make('Unauthorized', 401);
			}
			else
			{
				return redirect()->guest('login');
			}
		}
	}
}
