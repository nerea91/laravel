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

		// Clear cache
		Artisan::call('cache:clear');

		// Seed
		$this->call('CurrenciesTableSeeder');
		$this->call('CountriesTableSeeder');
		$this->call('LanguagesTableSeeder');
		$this->call('PermissionTypesTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('ProfilesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('AuthprovidersTableSeeder');
		$this->call('AccountsTableSeeder');

		// Setup initial configuration
		Artisan::call('setup', [
			'currencies' => ['EUR'],
			//'countries' => [],
			'languages' => ['en', 'es'], // First in the list will be the default
		]);
	}
}
