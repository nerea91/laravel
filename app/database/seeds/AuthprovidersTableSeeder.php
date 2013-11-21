<?php

class AuthprovidersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('authproviders')->delete();

		$providers = array(
			['id' => 1, 'name' => 'laravel', 'title' => 'Laravel']
		);

		DB::table('authproviders')->insert($providers);
	}

}
