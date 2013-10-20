<?php

class PermissionTypesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('permissiontypes')->delete();

		$permissiontypes = array(
			['id' => 1, 'name' => 'Users'],
			['id' => 2, 'name' => 'Profiles'],
			['id' => 3, 'name' => 'Authentication providers'],
			['id' => 4, 'name' => 'Countries'],
		);

		DB::table('permissiontypes')->insert($permissiontypes);
	}

}
