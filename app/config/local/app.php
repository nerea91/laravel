<?php

return array(

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
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => array(

		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		'Illuminate\Auth\AuthServiceProvider',
		'Illuminate\Cache\CacheServiceProvider',
		'Illuminate\Session\CommandsServiceProvider',
		'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
		'Illuminate\Routing\ControllerServiceProvider',
		'Illuminate\Cookie\CookieServiceProvider',
		'Illuminate\Database\DatabaseServiceProvider',
		'Illuminate\Encryption\EncryptionServiceProvider',
		'Illuminate\Filesystem\FilesystemServiceProvider',
		'Illuminate\Hashing\HashServiceProvider',
		'Illuminate\Html\HtmlServiceProvider',
		'Illuminate\Log\LogServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Database\MigrationServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Queue\QueueServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Remote\RemoteServiceProvider',
		'Illuminate\Auth\Reminders\ReminderServiceProvider',
		'Illuminate\Database\SeedServiceProvider',
		'Illuminate\Session\SessionServiceProvider',
		'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Illuminate\Workbench\WorkbenchServiceProvider',

		// require-dev
		'Barryvdh\Debugbar\ServiceProvider', //https://github.com/barryvdh/laravel-debugbar
		'Stolz\Filters\HtmlTidy\ServiceProvider', //https://github.com/Stolz/laravel-html-tidy
		'Stolz\SchemaSpy\ServiceProvider', //https://github.com/Stolz/laravel-schema-spy
		'Way\Generators\GeneratorsServiceProvider', //https://github.com/JeffreyWay/Laravel-4-Generators
		'DayleRees\ContainerDebug\ServiceProvider', //https://github.com/daylerees/container-debug
		'BCA\LaravelInspect\LaravelInspectServiceProvider', //https://github.com/brodkinca/BCA-Laravel-Inspect

		// require
		'Stolz\Assets\ManagerServiceProvider', //https://github.com/Stolz/Assets
		'Stevenmaguire\Foundation\FoundationServiceProvider', //https://github.com/stevenmaguire/zurb-foundation-laravel
		'Binarix\FoundationPagination\FoundationPaginationServiceProvider', //https://github.com/binarix/Laravel-Foundation-Pagination

	),

);
