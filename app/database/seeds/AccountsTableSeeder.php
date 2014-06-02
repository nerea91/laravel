<?php

class AccountsTableSeeder extends Seeder
{
	public function run()
	{
		$accounts = [
			['id' => 1, 'uid' => 1, 'nickname' => 'admin', 'name' => 'Admin', 'provider_id' => 1, 'user_id' => 1],
		];

		DB::table('accounts')->insert($accounts);
	}
}
