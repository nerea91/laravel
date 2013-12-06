<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Language
|--------------------------------------------------------------------------
|
| Set application language and bind it to the IoC container.
|
*/
if ( ! $app->runningInConsole())
{
	$app->singleton('language', function()
	{
		return Language::detect()->setLocale();
	});
}

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);

	//If debug is enabled keep using the default error view
	if (Config::get('app.debug')) {
		return;
	}

	$message = $exception->getMessage();

	$data = [
		'title'	=> strlen($message) ? $message : _('Error'),
		'header'=> $message,
		'code'	=> $code
	];

	switch ($code)
	{
		case 401:
			return Response::view('errors/401', $data, $code);

		case 404:
			return Response::view('errors/404', $data, $code);

		default:
			return Response::view('layouts/error', $data, $code);
	}
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	return Response::view('errors.maintenance', array('title' => _('Maintenance')), 503);
});

/*
|--------------------------------------------------------------------------
| Require our definitions files
|--------------------------------------------------------------------------
|
| This gives us a nice separate location to store our functions and
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/helpers.php';
require app_path().'/filters.php';
require app_path().'/others.php';
