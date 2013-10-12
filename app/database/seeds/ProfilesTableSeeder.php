<?php

class ProfilesTableSeeder extends Seeder {

	public function run()
	{
		$profiles = array(
			['id' => 1, 'name' => _('Superuser'), 'description' => _('Holds all the permissions')],
		);

		DB::table('profiles')->insert($profiles);
	}

}
