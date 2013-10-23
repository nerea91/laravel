<?php

/*
|--------------------------------------------------------------------------
| ACL Filter configuration
|--------------------------------------------------------------------------
|
| To define a map between the named routes and their required permissions:
|
| 'map' = array(
|    'route_name' => $permissions,
|    ...
| );
|
| $permissions should one of these:
| - an integer.
| - an array of integers.
| - a closure that returns a boolean. Example: function ($user) {return $user->hasAnyPermission(1,2,3);}
|
| This filter will deny access if any of these happend:
| - current route is not listed in the map array keys.
| - user's profile doesn't have all $permissions for 'route_name'.
| - $permissions is a closure that returns FALSE.
|
*/
return array(

	'map' => array(

		//Countries
		'countries.index' => 10,
		'countries.show' => 10,
		'countries.create' => 11,
		'countries.store' => 11,
		'countries.edit' => 12,
		'countries.update' => 12,
		'countries.destroy' => 13,

		//Languages
		'languages.index' => 20,
		'languages.show' => 20,
		'languages.create' => 21,
		'languages.store' => 21,
		'languages.edit' => 22,
		'languages.update' => 22,
		'languages.destroy' => 23,

		//Profiles
		'profiles.index' => 40,
		'profiles.show' => 40,
		'profiles.create' => 41,
		'profiles.store' => 41,
		'profiles.edit' => 42,
		'profiles.update' => 42,
		'profiles.destroy' => 43,

		//Users
		'users.index' => 60,
		'users.show' => 60,
		'users.create' => 61,
		'users.store' => 61,
		'users.edit' => 62,
		'users.update' => 62,
		'users.destroy' => 63,

		//Auth providers
		'authproviders.index' => 80,
		'authproviders.show' => 80,
		'authproviders.create' => 81,
		'authproviders.store' => 81,
		'authproviders.edit' => 82,
		'authproviders.update' => 82,
		'authproviders.destroy' => 83,

		//Accounts
		'accounts.index' => 100,
		'accounts.show' => 100,
		'accounts.create' => 101,
		'accounts.store' => 101,
		'accounts.edit' => 102,
		'accounts.update' => 102,
		'accounts.destroy' => 103,
	),

);
