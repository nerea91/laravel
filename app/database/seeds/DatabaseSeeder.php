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
		$this->call('OptionsTableSeeder');

		// Setup initial configuration
		Artisan::call('setup', [
			'--no-superuser' => null,
			'--currencies'	 => 'EUR',
			'--countries'	 => 'ESP',
			'--languages'	 => 'en,es', // First in the list will be the default one
		]);

		/*
		 * To trigger this use either:
		 *
		 *	php artisan db:seed --env=local
		 *	php artisan migrate:refresh --seed --env=local
		 *
		 */
		if (App::environment('local'))
		{
			$this->call('LocalEnvironmentSeeder');
		}
	}
}
