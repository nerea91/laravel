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

		// Admin panel main page
		'admin' => function ($user) {return $user->hasAnyPermission(range(10,103));},

		// Countries
		'admin.countries.index' => 10,
		'admin.countries.show' => 10,
		'admin.countries.create' => 11,
		'admin.countries.store' => 11,
		'admin.countries.edit' => 12,
		'admin.countries.update' => 12,
		'admin.countries.destroy' => 13,

		// Languages
		'admin.languages.index' => 20,
		'admin.languages.show' => 20,
		'admin.languages.create' => 21,
		'admin.languages.store' => 21,
		'admin.languages.edit' => 22,
		'admin.languages.update' => 22,
		'admin.languages.destroy' => 23,

		// Profiles
		'admin.profiles.index' => 40,
		'admin.profiles.show' => 40,
		'admin.profiles.create' => 41,
		'admin.profiles.store' => 41,
		'admin.profiles.edit' => 42,
		'admin.profiles.update' => 42,
		'admin.profiles.destroy' => 43,

		// Users
		'admin.users.index' => 60,
		'admin.users.show' => 60,
		'admin.users.create' => 61,
		'admin.users.store' => 61,
		'admin.users.edit' => 62,
		'admin.users.update' => 62,
		'admin.users.destroy' => 63,

		// Auth providers
		'admin.authproviders.index' => 80,
		'admin.authproviders.show' => 80,
		'admin.authproviders.create' => 81,
		'admin.authproviders.store' => 81,
		'admin.authproviders.edit' => 82,
		'admin.authproviders.update' => 82,
		'admin.authproviders.destroy' => 83,

		// Accounts
		'admin.accounts.index' => 100,
		'admin.accounts.show' => 100,
		'admin.accounts.create' => 101,
		'admin.accounts.store' => 101,
		'admin.accounts.edit' => 102,
		'admin.accounts.update' => 102,
		'admin.accounts.destroy' => 103,

		// Currencies
		'admin.currencies.index' => 120,
		'admin.currencies.show' => 120,
		'admin.currencies.create' => 121,
		'admin.currencies.store' => 121,
		'admin.currencies.edit' => 122,
		'admin.currencies.update' => 122,
		'admin.currencies.destroy' => 123,
	),

);
