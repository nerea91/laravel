<?php

return array(

	'pipeline'	=> true,
	'autoload'	=> array('foundation-cdn'),
	'collections' => array(

		//jQuery 1.x (CDN)
		'jquery-cdn' => ['//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'],

		//jQuery 2.x (CDN)
		'jquery2-cdn' => ['//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'],

		//jQuery UI (CDN)
		'jquery-ui-cdn' => [
			'jquery-cdn',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js',
			//Uncomment to load i18n for all languages other than English '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/i18n/jquery-ui-i18n.min.js',
			//Uncomment to load i18n for only one language (i.e: Spanish) '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/i18n/jquery.ui.datepicker-es.min.js',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.min.css',
		],

		//Zurb Foundation (CDN)
		'foundation-cdn' => [
			'//cdn.jsdelivr.net/foundation/5.2.2/js/vendor/modernizr.js',
			'jquery2-cdn',
			'//cdn.jsdelivr.net/foundation/5.2.2/js/foundation.min.js',
			'app.js',
			'//cdn.jsdelivr.net/foundation/5.2.2/css/normalize.css',
			'//cdn.jsdelivr.net/foundation/5.2.2/css/foundation.min.css',
		],

		//Zurb Responsive tables http://zurb.com/playground/responsive-tables
		'responsive-tables' => [
			'zurb/responsive-tables:responsive-tables.js',
			'zurb/responsive-tables:responsive-tables.css',
		],

		//Twitter Bootstrap (CDN)
		'bootstrap-cdn' => [
			'jquery-cdn',
			'//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js',
			'//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css',
			'//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css',
		],

		// Twitter Bootstrap. To install it run: composer require twitter/bootstrap:3.0.*; artisan asset:publish twitter/bootstrap --path=vendor/twitter/bootstrap/dist/
		'bootstrap' => [
			'jquery-cdn',
			'twitter/bootstrap:bootstrap.min.js',
			'twitter/bootstrap:bootstrap.min.css',
			'twitter/bootstrap:bootstrap-theme.min.css',
		],

		// Assets for admin panel
		'admin' => [
			'admin.js',
			'admin.css',
		],

		// PHP debugbar
		'debugbar' => [
			'//laravel/packages/barryvdh/laravel-debugbar/debugbar.js',
			'//laravel/packages/barryvdh/laravel-debugbar/widgets.js',
			'//laravel/packages/barryvdh/laravel-debugbar/openhandler.js',
			'//laravel/packages/barryvdh/laravel-debugbar/vendor/font-awesome/css/font-awesome.min.css',
			'//laravel/packages/barryvdh/laravel-debugbar/widgets.css',
			'//laravel/packages/barryvdh/laravel-debugbar/openhandler.css',
			'//laravel/packages/barryvdh/laravel-debugbar/debugbar.css',
		],

	),

);
