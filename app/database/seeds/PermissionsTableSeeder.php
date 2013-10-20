<?php

class PermissionsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('permissions')->delete();

		$permissions = array(

			//Countries (Reserved range: 0-19)
			['id' => 10, 'type_id' => 1, 'name' => _('View')],
			['id' => 11, 'type_id' => 1, 'name' => _('Add')],
			['id' => 12, 'type_id' => 1, 'name' => _('Edit')],
			['id' => 13, 'type_id' => 1, 'name' => _('Delete')],

			//Languages (Reserved range: 20-39)
			['id' => 20, 'type_id' => 2, 'name' => _('View')],
			['id' => 21, 'type_id' => 2, 'name' => _('Add')],
			['id' => 22, 'type_id' => 2, 'name' => _('Edit')],
			['id' => 23, 'type_id' => 2, 'name' => _('Delete')],

			//Profiles (Reserved range: 40-59)
			['id' => 40, 'type_id' => 3, 'name' => _('View')],
			['id' => 41, 'type_id' => 3, 'name' => _('Add')],
			['id' => 42, 'type_id' => 3, 'name' => _('Edit')],
			['id' => 43, 'type_id' => 3, 'name' => _('Delete')],

			//Users (Reserved range: 60-79)
			['id' => 60, 'type_id' => 4, 'name' => _('View')],
			['id' => 61, 'type_id' => 4, 'name' => _('Add')],
			['id' => 62, 'type_id' => 4, 'name' => _('Edit')],
			['id' => 63, 'type_id' => 4, 'name' => _('Delete')],

			//Auth providers (Reserved range: 80-99)
			['id' => 80, 'type_id' => 5, 'name' => _('View')],
			['id' => 81, 'type_id' => 5, 'name' => _('Add')],
			['id' => 82, 'type_id' => 5, 'name' => _('Edit')],
			['id' => 83, 'type_id' => 5, 'name' => _('Delete')],

			//Accounts (Reserved range: 100-119)
			['id' => 100, 'type_id' => 6, 'name' => _('View')],
			['id' => 101, 'type_id' => 6, 'name' => _('Add')],
			['id' => 102, 'type_id' => 6, 'name' => _('Edit')],
			['id' => 103, 'type_id' => 6, 'name' => _('Delete')],

		);

		DB::table('permissions')->insert($permissions);
	}

}
