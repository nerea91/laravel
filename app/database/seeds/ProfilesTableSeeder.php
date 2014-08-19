<?php

class ProfilesTableSeeder extends Seeder
{
	public function run()
	{
		$profiles = [
			['id' => 1, 'name' => 'Superuser', 'description' => 'Holds all the permissions'],
			['id' => 2, 'name' => 'User', 'description' => null],
		];

		DB::table('profiles')->insert(add_timestamps($profiles));

		//Add all permissions to Superuser profile
		DB::insert('INSERT INTO permission_profile (permission_id, profile_id, created_at, updated_at) SELECT id, 1, NOW(), NOW() FROM permissions');
	}
}
