<?php

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
	// HTML Tidy
	if (Config::get('tidy.enabled', false) and $response instanceof Illuminate\Http\Response and strpos($response->headers->get('content-type'), 'text/html') !== false)
	{
		//Parse output
		$tidy = new tidy;
		$tidy->parseString($response->getOriginalContent(), Config::get('tidy.options'), Config::get('tidy.encoding', 'utf8'));
		$tidy->cleanRepair();

		//Set doctype
		$output = Config::get('tidy.doctype', '<!DOCTYPE html>') . "\n" . preg_replace('_ xmlns="http://www.w3.org/1999/xhtml"_', null, $tidy, 1);

		//Append errors
		if ($tidy->getStatus() and Config::get('tidy.display_errors', false))
		{
			$errors = $tidy->errorBuffer;
			foreach(Config::get('tidy.filter', []) as $regex)
			{
				$errors = preg_replace($regex, null, $errors);
			}

			//Wrap errors in a container
			if (strlen($errors))
				$errors = Config::get('tidy.open', '<div>') . nl2br(htmlentities($errors)) . Config::get('tidy.close', '</div>');

			$output = str_replace ('</body>', $errors . '</body>', $output);
		}

		//Render $output
		$response->setContent($output);
	}

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

/*
|--------------------------------------------------------------------------
| ACL Filter
|--------------------------------------------------------------------------
|
| Relies on your User model having the hasPermission function on it.
| Read app/config/acl.php for more info about this filter.
|
*/

Route::filter('acl', function()
{
	$acl = Config::get('acl.map', []);
	$route = Route::currentRouteName();

	try
	{
		if( ! isset($acl[$route]))
			throw new Exception('ACL: ' . _('Unknown route') . " $route");

		$permissions = $acl[$route];
		$is_closure = ($permissions instanceof Closure);

		if($is_closure AND ! $permissions(Auth::user()))
			throw new Exception(_('Unauthorized profile'));

		if( ! $is_closure AND ! Auth::user()->hasPermission($permissions))
			throw new Exception(_('Unauthorized profile'));
	}
	catch(Exception $e)
	{
		return App::abort(401, $e->getMessage());
	}
});
