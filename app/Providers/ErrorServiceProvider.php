<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App, Config, Exception, Log, Response;

class ErrorServiceProvider extends ServiceProvider {

	/**
	 * Register any error handlers.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Here you may handle any errors that occur in your application, including
		// logging them or displaying custom views for specific errors. You may
		// even register several error handlers to handle different types of
		// exceptions. If nothing is returned, the default error view is
		// shown, which includes a detailed stack trace during debug.

		App::error(function(Exception $exception, $code) {

			// Add exception to log file
			Log::error($exception);

			// If debug is enabled keep using the default error view
			if (Config::get('app.debug'))
				return;

			// Otherwise load a custom view deppending on the error code
			$data = [
				'title'  => _('Error')." $code",
				'header' => $exception->getMessage(),
				'code'   => $code
			];

			switch($code)
			{
				case 401:
					return Response::view('errors/401', $data, $code);

				case 404:
					return Response::view('errors/404', $data, $code);

				default:
					return Response::view('layouts/error', $data, $code);
			}
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
