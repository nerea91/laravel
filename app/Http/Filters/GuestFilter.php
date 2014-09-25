<?php namespace App\Http\Filters;

use Auth;

class GuestFilter
{
	/**
	 * Run the request filter.
	 *
	 * @return mixed
	 */
	public function filter()
	{
		if (Auth::check())
		{
			return redirect('/');
		}
	}
}
