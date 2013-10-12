<?php

class PermissionTypesTableSeeder extends Seeder {

	public function run()
	{
// 		DB::table('permissiontypes')->truncate();

		$permissiontypes = array(
			['id' => 1, 'name' => _('Users')],
			['id' => 2, 'name' => _('Profiles')],
		);

		DB::table('permissiontypes')->insert($permissiontypes);
	}

}
