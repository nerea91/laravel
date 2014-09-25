<?php namespace App\Http\Filters;

use App\Exceptions\AccessControlListException;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class AccessControlListFilter
{
	/**
	 * Check if current user has granted access to current route.
	 * The permissions list is defined in config/acl.php
	 *
	 * @param  \Illuminate\Routing\Route $route
	 * @param  \Illuminate\Http\Request  $request
	 * @return mixed
	 * @throws \App\Exceptions\AccessControlListException
	 */
	public function filter(Route $route, Request $request)
	{
		$acl = config('acl.map', []);
		$routeName = $route->getName();
		$user = Auth::user();

		try
		{
			// If route is not listed in the config file deny access
			if( ! isset($acl[$routeName]))
				throw new AccessControlListException(_('Unknown route') . " $routeName");

			$permissions = $acl[$routeName];
			$isClosure = ($permissions instanceof Closure);

			// If permissions are determined by a closure run the closure
			if($isClosure and ! $permissions($user))
				throw new AccessControlListException(_('Authorization condition failed'));

			// Otherwise check if user's profile has the required permission
			if( ! $isClosure and ! $user->hasPermission($permissions))
				throw new AccessControlListException(_('Unauthorized profile'));
		}
		catch(AccessControlListException $e)
		{
			return app()->abort(401, $e->getMessage());
		}
	}
}
