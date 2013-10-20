<?php

class PermissionTypesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('permissiontypes')->delete();

		$permissiontypes = array(
			['id' => 1, 'name' => _('Users')],
			['id' => 2, 'name' => _('Profiles')],
			['id' => 3, 'name' => _('Authentication providers')],
			['id' => 4, 'name' => _('Countries')],
			['id' => 5, 'name' => _('Accounts')],
		);

		DB::table('permissiontypes')->insert($permissiontypes);
	}

}
