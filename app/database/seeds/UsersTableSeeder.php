<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
// 		DB::table('users')->truncate();

		$users = array(
			['name' => 'Javi', 'email' => 'javi@example.com', 'age' => 33, 'country_id' => 724]
		);

		// Uncomment the below to run the seeder
		DB::table('users')->insert($users);
	}

}
