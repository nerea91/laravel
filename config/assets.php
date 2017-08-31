<?php

return [
	'pipeline' => env('ASSETS_PIPELINE', false),
	'collections' => [

		// Zurb Foundation
		'master' => ['master.css', 'master.js'],
		'admin' => ['admin.css', 'admin.js'],

		// PHP debugbar
		'debugbar' => ['debugbar.css', 'debugbar.js'],

		// Offcanvas extras
		'offcanvas' => ['offcanvas.css', 'offcanvas.js'],

		// Datepicker https://github.com/najlepsiwebdesigner/foundation-datepicker
		'datepicker' => [
			'datepicker.css',
			'foundation-datepicker.js',
			'foundation-datepicker.es.js'
		],

		// Responsive tables http://zurb.com/playground/responsive-tables
		'responsive-tables' => [
			'responsive-tables.js',
			'responsive-tables.css',
		],

		// Data Tables https://github.com/DataTables/DataTables
		'datatables' => [
			'datatables.css',
			'datatables.js'
		],

	],
];
