<?php

/*
|--------------------------------------------------------------------------
| ACL Filter
|--------------------------------------------------------------------------
|
| By default rejects access unless current route is listed and
| current user's profile has permissions to access it
|
*/

Route::filter('acl', function()
{
	$permissions_map = array(
		//Users
		'users.index' => 100,
		'users.show ' => 100,
		'users.create' => 101,
		'users.store ' => 101,
		'users.edit' => 102,
		'users.update' => 102,
		'users.destroy' => 103,

		//Profiles
		'profiles.index' => 200,
		'profiles.show ' => 200,
		'profiles.create' => 201,
		'profiles.store ' => 201,
		'profiles.edit' => 202,
		'profiles.update' => 202,
		'profiles.destroy' => 203,

		//Auth providers
		'authproviders.index' => 300,
		'authproviders.show ' => 300,
		'authproviders.create' => 301,
		'authproviders.store ' => 301,
		'authproviders.edit' => 302,
		'authproviders.update' => 302,
		'authproviders.destroy' => 303,
	);

	$route_name = Route::currentRouteName();

	if( ! isset($permissions_map[$route_name]) OR ! Auth::user()->hasPermission($permissions_map[$route_name]))
		App::abort(403);
});


/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

