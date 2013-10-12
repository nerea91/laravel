<?php

class PermissionsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('permissions')->delete();

		$permissions = array(
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
		);

		DB::table('permissions')->insert($permissions);
	}

}
