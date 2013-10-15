<?php

return array(

	//'autoload' => array(),

	'collections' => array(

		//jQuery (CDN)
		'jquery-cdn' => ['//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'],

		//jQuery UI (CDN)
		'jquery-ui-cdn' => [
			'jquery-cdn',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',
			//Uncomment to load i18n for all languages other than English '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js',
			//Uncomment to load i18n for only one language (i.e: Spanish) '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery.ui.datepicker-es.min.js',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css',
		],

		//Zurb Foundation (CDN)
		'foundation-cdn' => [
			'jquery-cdn',
			'//cdn.jsdelivr.net/foundation/4.3.2/css/foundation.min.css',
			'//cdn.jsdelivr.net/foundation/4.3.2/js/foundation.min.js',
			'app.js'
		],

		//Twitter Bootstrap (CDN)
		'bootstrap-cdn' => [
			'jquery-cdn',
			'//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css',
			'//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css',
			'//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'
		],

		// Twitter Bootstrap. To install it run: composer require twitter/bootstrap:3.0.*; artisan asset:publish twitter/bootstrap --path=vendor/twitter/bootstrap/dist/
		'bootstrap' => [
			'jquery-cdn',
			'twitter/bootstrap:bootstrap.min.css',
			'twitter/bootstrap:bootstrap-theme.min.css',
			'twitter/bootstrap:bootstrap.min.js'
		],
	),

);
