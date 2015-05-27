<?php

/*
|--------------------------------------------------------------------------
| ACL Filter configuration
|--------------------------------------------------------------------------
|
| To define a map between the named routes and their required permissions:
|
| [
|    'route_name' => $permissions,
|    ...
| ];
|
| $permissions should one of these:
| - an integer.
| - an array of integers.
| - a closure that returns a boolean. The closue will get an instance of Auth::user() as first argument.
|    Example: function ($user) {return $user->hasAnyPermission(1,2,3);}
|
| This filter will deny access if any of these happend:
| - current route is not listed in the array keys.
| - user's profile doesn't have all $permissions for 'route_name'.
| - $permissions is a closure that returns FALSE.
|
*/

$onlyIfLocalEnvironment = function () {
	return app()->environment('local');
};

return [

	'test' => $onlyIfLocalEnvironment,

	// Reports
	'report.sample' => $onlyIfLocalEnvironment,
	'report.sample.validate' => $onlyIfLocalEnvironment,
	#_REPORT_GENERATOR_MARKER_#_DO_NOT_REMOVE_#

	// Countries
	'admin.countries.index' => 10,
	'admin.countries.show' => 10,
	'admin.countries.create' => 11,
	'admin.countries.store' => 11,
	'admin.countries.edit' => 12,
	'admin.countries.update' => 12,
	'admin.countries.destroy' => 13,
	'admin.countries.restore' => 13,
	'admin.countries.trash.mode' => 13,

	// Languages
	'admin.languages.index' => 20,
	'admin.languages.show' => 20,
	'admin.languages.create' => 21,
	'admin.languages.store' => 21,
	'admin.languages.edit' => 22,
	'admin.languages.update' => 22,
	'admin.languages.destroy' => 23,
	'admin.languages.restore' => 23,
	'admin.languages.trash.mode' => 23,

	// Profiles
	'admin.profiles.index' => 40,
	'admin.profiles.show' => 40,
	'admin.profiles.create' => 41,
	'admin.profiles.store' => 41,
	'admin.profiles.edit' => 42,
	'admin.profiles.update' => 42,
	'admin.profiles.destroy' => 43,
	'admin.profiles.restore' => 43,
	'admin.profiles.trash.mode' => 43,

	// Users
	'admin.users.index' => 60,
	'admin.users.show' => 60,
	'admin.users.create' => 61,
	'admin.users.store' => 61,
	'admin.users.edit' => 62,
	'admin.users.update' => 62,
	'admin.users.destroy' => 63,
	'admin.users.restore' => 63,
	'admin.users.trash.mode' => 63,

	// Auth providers
	'admin.authproviders.index' => 80,
	'admin.authproviders.show' => 80,
	'admin.authproviders.create' => 81,
	'admin.authproviders.store' => 81,
	'admin.authproviders.edit' => 82,
	'admin.authproviders.update' => 82,
	'admin.authproviders.destroy' => 83,
	'admin.authproviders.restore' => 83,
	'admin.authproviders.trash.mode' => 83,

	// Accounts
	'admin.accounts.index' => 100,
	'admin.accounts.show' => 100,
	'admin.accounts.create' => 101,
	'admin.accounts.store' => 101,
	'admin.accounts.edit' => 102,
	'admin.accounts.update' => 102,
	'admin.accounts.destroy' => 103,
	'admin.accounts.restore' => 103,
	'admin.accounts.trash.mode' => 103,

	// Currencies
	'admin.currencies.index' => 120,
	'admin.currencies.show' => 120,
	'admin.currencies.create' => 121,
	'admin.currencies.store' => 121,
	'admin.currencies.edit' => 122,
	'admin.currencies.update' => 122,
	'admin.currencies.destroy' => 123,
	'admin.currencies.restore' => 123,
	'admin.currencies.trash.mode' => 123,

	// Documents
	'admin.documents.index' => 140,
	'admin.documents.show' => 140,
	'admin.documents.create' => 141,
	'admin.documents.store' => 141,
	'admin.documents.edit' => 142,
	'admin.documents.update' => 142,
	'admin.documents.destroy' => 143,
	'admin.documents.restore' => 143,
	'admin.documents.trash.mode' => 143,

	#_RESOURCE_GENERATOR_MARKER_#_DO_NOT_REMOVE_#

];
