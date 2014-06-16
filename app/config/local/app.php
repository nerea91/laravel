<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| Enabled for local environment.
	|
	*/

	'debug' => true,

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| It's considered a good practice to have separate keys for local and
	| production environment.
	|
	| Use a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => 'to-do key for local environment.', //to-do

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
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

);
