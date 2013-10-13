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
		$this->command->comment('Countries');

		$this->call('LanguagesTableSeeder');
		$this->command->comment('Languages');

		$this->call('PermissionTypesTableSeeder');
		$this->command->comment('PermissionTypes');

		$this->call('PermissionsTableSeeder');
		$this->command->comment('Permissions');

		$this->call('ProfilesTableSeeder');
		$this->command->comment('Profiles');

		$this->call('UsersTableSeeder');
		$this->command->comment('Users');

		$this->call('AuthprovidersTableSeeder');
		$this->command->comment('Auth Providers');

		$this->call('AccountsTableSeeder');
		$this->command->comment('Accounts');
	}
}
