<?php

class ProfilesTableSeeder extends Seeder
{
	public function run()
	{
		$profiles = [
			['id' => 1, 'name' => 'Superuser', 'description' => 'Holds all the permissions'],
		];

		DB::table('profiles')->insert($profiles);

		//Add all permissions to Superuser profile
		DB::insert('INSERT INTO permission_profile (permission_id, profile_id) SELECT id, 1 FROM permissions');
	}
}
