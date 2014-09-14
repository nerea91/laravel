<?php

class AuthprovidersTableSeeder extends Seeder
{
	public function run()
	{
		$providers = [
			['id' => 1, 'name' => 'laravel', 'title' => 'Laravel'],
		];

		DB::table('authproviders')->insert(add_timestamps($providers));
	}
}
