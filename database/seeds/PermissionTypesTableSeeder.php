<?php

use Illuminate\Database\Seeder;

class PermissionTypesTableSeeder extends Seeder
{
	public function run()
	{
		$types = [
			['id' => 1, 'name' => _('Countries')],
			['id' => 2, 'name' => _('Languages')],
			['id' => 3, 'name' => _('Profiles')],
			['id' => 4, 'name' => _('Users')],
			['id' => 5, 'name' => _('Authentication providers')],
			['id' => 6, 'name' => _('Accounts')],
			['id' => 7, 'name' => _('Currencies')],
			['id' => 8, 'name' => _('Documents')],
		];

		DB::table('permissiontypes')->insert($types);
	}
}
