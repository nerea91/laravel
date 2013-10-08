<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Library Debug Mode
	|--------------------------------------------------------------------------
	|
	| When debug mode is enabled information about the process of loading
	| assets will be sent to the log.
	|
	*/

// 	'debug' => TRUE,

	/*
	|--------------------------------------------------------------------------
	| Local assets directories
	|--------------------------------------------------------------------------
	|
	| Override defaul prefix folder for local assets.
	| Don't use trailing slash!.
	|
	*/

	//'css_dir' => '/css',
	//'js_dir' => '/js',

	/*
	|--------------------------------------------------------------------------
	| Assets collections
	|--------------------------------------------------------------------------
	|
	| Collections allow you to have named groups of assets (CSS or JavaScript files).
	|
	| If an asset has been loaded already it won't be added again. Collections may be
	| nested but please be careful to avoid recursive loops.
	|
	| To avoid conflicts with the autodetection of asset types make sure your
	| collections names dont end with ".js" or ".css".
	|
	|
	| Example:
	|	'collections' => array(
	|		'uno'	=> 'uno.css',
	|		'dos'	=> ['dos.css', 'dos.js'],
	|		'external'	=> ['http://example.com/external.css', 'https://secure.example.com/https.css', '//example.com/protocol/agnostic.js'],
	|		'mix'	=> ['internal.css', 'http://example.com/external.js'],
	|		'nested' => ['uno', 'dos'],
	|		'duplicated' => ['nested', 'uno.css','dos.css', 'tres.js'],
	|		'unknown' => 'xxxxxxx',
	|	),
	*/

		'collections' => array(

			//Twitter Bootstrap 3 (CDN)
			'bootstrap-cdn' => ['//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'],

			/* Twitter Bootstrap 3 (local). To get Bootstrap:
			$ composer require twitter/bootstrap:3.0.*
			$ artisan asset:publish twitter/bootstrap --path=vendor/twitter/bootstrap/dist/)*/
			'bootstrap' => [url('packages/twitter/bootstrap/css/bootstrap.min.css'), url('packages/twitter/bootstrap/css/bootstrap-theme.min.css'), url('packages/twitter/bootstrap/js/bootstrap.min.js')],
		),

	/*
	|--------------------------------------------------------------------------
	| Preload assets
	|--------------------------------------------------------------------------
	|
	| Here you may set which assets (CSS files, JavaScript files or collections)
	| should be loaded by default.
	|
	*/
// 	'autoload' => array(),
);
