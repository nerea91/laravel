<?php namespace App\Providers;

use Exception;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Exception\Handler;
use Response;

class ErrorServiceProvider extends ServiceProvider
{
	/**
	 * Register any error handlers.
	 *
	 * @param  Handler  $handler
	 * @param  Log  $log
	 * @return void
	 */
	public function boot(Handler $handler, Log $log)
	{
		// Here you may handle any errors that occur in your application, including
		// logging them or displaying custom views for specific errors. You may
		// even register several error handlers to handle different types of
		// exceptions. If nothing is returned, the default error view is
		// shown, which includes a detailed stack trace during debug.
		$handler->error(function(Exception $e) use ($log) {

			// Add exception to log file
			$log->error($e);

			// If debug is enabled keep using the default error view
			if (config('app.debug'))
				return;

			// Otherwise load a custom view deppending on the error code
			$code = ($e->getCode()) ?: 500; //to-do Workaround debido a que el nuevo error handler de Laravel no informa del codigo HTTP en la excepcion.
			$data = [
				'title'  => _('Error')." $code",
				'header' => $e->getMessage(),
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
