<?php

class PostsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
// 		DB::table('posts')->truncate();

		$posts = array(
			['user_id' => 1, 'title' => 'Primer post', 'body' => 'Este es mi primer post']
		);

		// Uncomment the below to run the seeder
		DB::table('posts')->insert($posts);
	}

}
