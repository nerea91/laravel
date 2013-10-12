<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		$users = array(
			['id' => 1, 'name' => 'admin', 'email' => 'admin@example.com', 'age' => 33, 'country_id' => 724]
		);

		DB::table('users')->insert($users);
	}

}
