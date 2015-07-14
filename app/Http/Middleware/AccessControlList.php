<?php namespace App\Http\Middleware;

use App\Exceptions\AccessControlListException;
use Closure;
use Illuminate\Contracts\Routing\Middleware;

class AccessControlList implements Middleware
{
	/**
	 * Check if current user has granted access to current route.
	 * The permissions list is defined in config/acl.php
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 * @throws \App\Exceptions\AccessControlListException
	 */
	public function handle($request, Closure $next)
	{
		$acl = config('acl', []);
		$routeName = $request->route()->getName();
		$user = auth()->user();

		try
		{
			// If route is not listed in the config file deny access
			if( ! isset($acl[$routeName]))
				throw new AccessControlListException(_('Unknown route') . ": $routeName");

			$permissions = $acl[$routeName];
			$isClosure = ($permissions instanceof Closure);

			// If permissions are determined by a closure run the closure
			if($isClosure and ! $permissions($user))
				throw new AccessControlListException(_('Authorization condition failed'));

			// Otherwise check if user's profile has the required permission
			if( ! $isClosure and ! $user->hasPermission($permissions))
				throw new AccessControlListException(_('Unauthorized profile'));

			return $next($request);
		}
		catch(AccessControlListException $e)
		{
			return abort(401, $e->getMessage());
		}
	}
}
