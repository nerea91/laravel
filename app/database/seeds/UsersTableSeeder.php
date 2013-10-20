<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		$users = array(
			['id' => 1, 'username' => 'admin', 'name' => 'Admin', 'password' => Hash::make('admin'), 'profile_id' => 1]
		);

		DB::table('users')->insert($users);
	}

}