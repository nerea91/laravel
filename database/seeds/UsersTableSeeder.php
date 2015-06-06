<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	public function run()
	{
		$users = [
			['id' => 1, 'username' => 'admin', 'name' => 'Admin', 'password' => Hash::make('secret'), 'profile_id' => 1],
		];

		DB::table('users')->insert(add_timestamps($users));
	}
}
