<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
	public function run()
	{
		$permissions = [

			// Reports (Reserved range: TODO)
			#_REPORT_GENERATOR_MARKER_#_DO_NOT_REMOVE_#

			// Countries (Reserved range: 0-19)
			['id' => 10, 'type_id' => 1, 'name' => _('View')],
			['id' => 11, 'type_id' => 1, 'name' => _('Add')],
			['id' => 12, 'type_id' => 1, 'name' => _('Edit')],
			['id' => 13, 'type_id' => 1, 'name' => _('Delete')],

			// Languages (Reserved range: 20-39)
			['id' => 20, 'type_id' => 2, 'name' => _('View')],
			['id' => 21, 'type_id' => 2, 'name' => _('Add')],
			['id' => 22, 'type_id' => 2, 'name' => _('Edit')],
			['id' => 23, 'type_id' => 2, 'name' => _('Delete')],

			// Profiles (Reserved range: 40-59)
			['id' => 40, 'type_id' => 3, 'name' => _('View')],
			['id' => 41, 'type_id' => 3, 'name' => _('Add')],
			['id' => 42, 'type_id' => 3, 'name' => _('Edit')],
			['id' => 43, 'type_id' => 3, 'name' => _('Delete')],

			// Users (Reserved range: 60-79)
			['id' => 60, 'type_id' => 4, 'name' => _('View')],
			['id' => 61, 'type_id' => 4, 'name' => _('Add')],
			['id' => 62, 'type_id' => 4, 'name' => _('Edit')],
			['id' => 63, 'type_id' => 4, 'name' => _('Delete')],

			// Auth providers (Reserved range: 80-99)
			['id' => 80, 'type_id' => 5, 'name' => _('View')],
			['id' => 81, 'type_id' => 5, 'name' => _('Add')],
			['id' => 82, 'type_id' => 5, 'name' => _('Edit')],
			['id' => 83, 'type_id' => 5, 'name' => _('Delete')],

			// Accounts (Reserved range: 100-119)
			['id' => 100, 'type_id' => 6, 'name' => _('View')],
			['id' => 101, 'type_id' => 6, 'name' => _('Add')],
			['id' => 102, 'type_id' => 6, 'name' => _('Edit')],
			['id' => 103, 'type_id' => 6, 'name' => _('Delete')],

			// Currencies (Reserved range: 120-139)
			['id' => 120, 'type_id' => 7, 'name' => _('View')],
			['id' => 121, 'type_id' => 7, 'name' => _('Add')],
			['id' => 122, 'type_id' => 7, 'name' => _('Edit')],
			['id' => 123, 'type_id' => 7, 'name' => _('Delete')],

			// Documents (Reserved range: 140-159)
			['id' => 140, 'type_id' => 8, 'name' => _('View')],
			['id' => 141, 'type_id' => 8, 'name' => _('Add')],
			['id' => 142, 'type_id' => 8, 'name' => _('Edit')],
			['id' => 143, 'type_id' => 8, 'name' => _('Delete')],

			#_RESOURCE_GENERATOR_MARKER_#_DO_NOT_REMOVE_#

		];

		DB::table('permissions')->insert($permissions);
	}
}
