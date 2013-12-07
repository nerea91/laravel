<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$users = array(
			['id' => 1, 'username' => 'admin', 'name' => 'Admin', 'password' => Hash::make('secret'), 'profile_id' => 1]
		);

		DB::table('users')->insert($users);
	}

}
