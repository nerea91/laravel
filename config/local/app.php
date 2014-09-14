<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => true,


	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => 'to-do key for local environment.', //to-do

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	| Using the append_config() helper method these service providers will be
	| append to the ones on production environment.
	|
	*/

	'providers' => append_config([

		'Barryvdh\Debugbar\ServiceProvider', //https://github.com/barryvdh/laravel-debugbar
		'DayleRees\ContainerDebug\ServiceProvider', //https://github.com/daylerees/container-debug
		'Stolz\Filters\HtmlTidy\ServiceProvider', //https://github.com/Stolz/laravel-html-tidy
		'Stolz\SchemaSpy\ServiceProvider', //https://github.com/Stolz/laravel-schema-spy
		'Way\Generators\GeneratorsServiceProvider', //https://github.com/JeffreyWay/Laravel-4-Generators

	]),

];
