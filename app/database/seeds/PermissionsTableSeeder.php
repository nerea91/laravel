<?php

class PermissionsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('permissions')->delete();

		$permissions = array(

			//Countries
			['id' => 10, 'type_id' => 4, 'name' => _('View')],
			['id' => 11, 'type_id' => 4, 'name' => _('Add')],
			['id' => 12, 'type_id' => 4, 'name' => _('Edit')],
			['id' => 13, 'type_id' => 4, 'name' => _('Delete')],

			//Users
			['id' => 100, 'type_id' => 1, 'name' => _('View')],
			['id' => 101, 'type_id' => 1, 'name' => _('Add')],
			['id' => 102, 'type_id' => 1, 'name' => _('Edit')],
			['id' => 103, 'type_id' => 1, 'name' => _('Delete')],

			//Profiles
			['id' => 200, 'type_id' => 2, 'name' => _('View')],
			['id' => 201, 'type_id' => 2, 'name' => _('Add')],
			['id' => 202, 'type_id' => 2, 'name' => _('Edit')],
			['id' => 203, 'type_id' => 2, 'name' => _('Delete')],

			//Auth providers
			['id' => 300, 'type_id' => 3, 'name' => _('View')],
			['id' => 301, 'type_id' => 3, 'name' => _('Add')],
			['id' => 302, 'type_id' => 3, 'name' => _('Edit')],
			['id' => 303, 'type_id' => 3, 'name' => _('Delete')],
		);

		DB::table('permissions')->insert($permissions);
	}

}
