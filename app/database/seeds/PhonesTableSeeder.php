<?php

class PhonesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('phones')->truncate();

		$phones = array(
			['user_id' => 1, 'number' => 655633, 'imei' => 999999999999]
		);

		// Uncomment the below to run the seeder
		DB::table('phones')->insert($phones);
	}

}
