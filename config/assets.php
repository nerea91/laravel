<?php

return [
	'pipeline' => env('ASSETS_PIPELINE', false),
	'autoload' => ['foundation'],
	'collections' => [

		// Zurb Foundation
		'foundation' => ['zurb/foundation:app.css', 'zurb/foundation:app.js', 'app.js'],

		// Admin panel
		'admin' => ['admin.css', 'admin.js'],

		// Zurb Foundation Offcanvas extras
		'offcanvas' => ['offcanvas.js', 'offcanvas.css'],

		// PHP debugbar https://github.com/barryvdh/laravel-debugbar
		'debugbar' => ['debugbar.css', 'debugbar.js'],

		// Zurb Responsive tables http://zurb.com/playground/responsive-tables
		'responsive-tables' => [
			'zurb/responsive-tables:responsive-tables.js',
			'zurb/responsive-tables:responsive-tables.css',
		],

		// Zurb Foundation datepicker https://github.com/najlepsiwebdesigner/foundation-datepicker
		'datepicker' => [
			'peterbeno/datepicker:datepicker.css',
			'peterbeno/datepicker:datepicker.js'
		],

		// Data Tables https://github.com/DataTables/DataTables
		'data-tables' => [
			'datatables/datatables:jquery.dataTables.min.css',
			'datatables/datatables:jquery.dataTables.min.js',
			'datatables/datatables:dataTables.foundation.css',
			'datatables/datatables:dataTables.foundation.js',
		],

	],
];
