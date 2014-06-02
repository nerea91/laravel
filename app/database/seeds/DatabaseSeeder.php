<?php

class DatabaseSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// Seeds
		$this->call('CurrenciesTableSeeder');
		$this->call('CountriesTableSeeder');
		$this->call('LanguagesTableSeeder');
		$this->call('PermissionTypesTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('ProfilesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('AuthprovidersTableSeeder');
		$this->call('AccountsTableSeeder');

		// Clear cache
		Artisan::call('cache:clear');
	}
}
