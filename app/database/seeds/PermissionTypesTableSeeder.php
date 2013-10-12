<?php

class PermissionTypesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('permissiontypes')->truncate();

		$permissiontypes = array(
			['id' => 1, 'name' => 'Users'],
			['id' => 2, 'name' => 'Profiles'],
		);

		DB::table('permissiontypes')->insert($permissiontypes);
	}

}
