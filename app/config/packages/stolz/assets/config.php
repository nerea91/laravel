<?php

// Get protocol agnostinc version of the configured application URL
$appUrl = rtrim(substr($appUrl = Config::get('app.url'), strpos($appUrl, ':') + 1), '/');

return [

	'pipeline'	=> true,
	'autoload'	=> ['foundation-cdn'],
	'collections' => [

		// jQuery 1.x (CDN)
		'jquery-cdn' => ['//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'],

		// jQuery 2.x (CDN)
		'jquery2-cdn' => ['//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'],

		// jQuery UI (CDN)
		'jquery-ui-cdn' => [
			'jquery-cdn',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js',
			//Uncomment to load i18n for all languages other than English '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/i18n/jquery-ui-i18n.min.js',
			//Uncomment to load i18n for only one language (i.e: Spanish) '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/i18n/jquery.ui.datepicker-es.min.js',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.min.css',
		],

		// Zurb Foundation (CDN)
		'foundation-cdn' => [
			'//cdn.jsdelivr.net/foundation/5.3.3/js/vendor/modernizr.js',
			'jquery2-cdn',
			'//cdn.jsdelivr.net/foundation/5.3.3/js/foundation.min.js',
			'app.js',
			'//cdn.jsdelivr.net/foundation/5.3.3/css/normalize.css',
			'//cdn.jsdelivr.net/foundation/5.3.3/css/foundation.min.css',
		],

		// Zurb Responsive tables http://zurb.com/playground/responsive-tables
		'responsive-tables' => [
			'zurb/responsive-tables:responsive-tables.js',
			'zurb/responsive-tables:responsive-tables.css',
		],

		// Flags of all countries in one sprite. https://github.com/lafeber/world-flags-sprite
		'flags-sprite-16px' => ['//cloud.github.com/downloads/lafeber/world-flags-sprite/flags16.css'],
		'flags-sprite-32px' => ['//cloud.github.com/downloads/lafeber/world-flags-sprite/flags21.css'],

		// Admin panel
		'admin' => [
			'admin.js',
			'admin.css',
		],

		// PHP debugbar
		'debugbar' => [
			"$appUrl/packages/barryvdh/laravel-debugbar/debugbar.js",
			"$appUrl/packages/barryvdh/laravel-debugbar/widgets.js",
			"$appUrl/packages/barryvdh/laravel-debugbar/openhandler.js",
			"$appUrl/packages/barryvdh/laravel-debugbar/vendor/font-awesome/css/font-awesome.min.css",
			"$appUrl/packages/barryvdh/laravel-debugbar/widgets.css",
			"$appUrl/packages/barryvdh/laravel-debugbar/openhandler.css",
			"$appUrl/packages/barryvdh/laravel-debugbar/debugbar.css",
		],

	],

];
