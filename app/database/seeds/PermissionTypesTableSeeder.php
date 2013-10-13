<?php

class PermissionTypesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('permissiontypes')->delete();

		$permissiontypes = array(
			['id' => 1, 'name' => _('Users')],
			['id' => 2, 'name' => _('Profiles')],
			['id' => 3, 'name' => _('Authentication providers')],
		);

		DB::table('permissiontypes')->insert($permissiontypes);
	}

}
