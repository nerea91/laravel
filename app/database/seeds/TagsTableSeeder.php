<?php

class TagsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
// 		DB::table('tags')->truncate();

		$tags = array(
			['name' => 'foo'],
			['name' => 'bar'],
			['name' => 'boogy'],
			['name' => 'pim'],
			['name' => 'pam'],
		);

		// Uncomment the below to run the seeder
		DB::table('tags')->insert($tags);
	}

}
