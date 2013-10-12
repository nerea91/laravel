<?php

return array(

	// 	'autoload' => array(),

	'collections' => array(

		//Zurb Foundation 4.3.2 (CDN)
		'foundation-cdn' => [
			'//cdn.jsdelivr.net/foundation/4.3.2/css/foundation.min.css',
			'//cdn.jsdelivr.net/foundation/4.3.2/js/foundation.min.js'
		],

		//Twitter Bootstrap 3 (CDN)
		'bootstrap-cdn' => [
			'//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css',
			'//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css',
			'//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js'
		],

		/* Twitter Bootstrap 3 (local). To get Bootstrap:
		composer require twitter/bootstrap:3.0.*; artisan asset:publish twitter/bootstrap --path=vendor/twitter/bootstrap/dist/)
		*/
		'bootstrap' => [
			'twitter/bootstrap:bootstrap.min.css',
			'twitter/bootstrap:bootstrap-theme.min.css',
			'twitter/bootstrap:bootstrap.min.js'
		],
	),

);
