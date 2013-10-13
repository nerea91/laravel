<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->command->question('Seeding...');

		$this->call('CountriesTableSeeder');
		$this->command->comment('Countries table seeded');

		$this->call('LanguagesTableSeeder');
		$this->command->comment('Languages table seeded');

		$this->call('PermissionTypesTableSeeder');
		$this->command->comment('PermissionTypes table seeded');

		$this->call('PermissionsTableSeeder');
		$this->command->comment('Permissions table seeded');

		$this->call('ProfilesTableSeeder');
		$this->command->comment('Profiles table seeded');

		$this->call('UsersTableSeeder');
		$this->command->comment('Users table seeded');

		$this->call('AuthprovidersTableSeeder');
		$this->command->comment('Auth Providers table seeded');
	}
}
