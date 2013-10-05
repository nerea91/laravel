<?php

class TagsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
// 		DB::table('tags')->truncate();

		$tags = array(
			['name' => 'tag1'],
			['name' => 'tag2'],
			['name' => 'tag3'],
			['name' => 'tag4'],
			['name' => 'tag5'],
		);

		// Uncomment the below to run the seeder
		DB::table('tags')->insert($tags);
	}

}
