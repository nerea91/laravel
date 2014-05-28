<?php

class AuthprovidersTableSeeder extends Seeder
{

	public function run()
	{
		$providers = array(
			['id' => 1, 'name' => 'laravel', 'title' => 'Laravel']
		);

		DB::table('authproviders')->insert($providers);
	}
}
