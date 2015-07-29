<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Disable mass-assign protection
		Model::unguard();

		// Clear cache
		Artisan::call('cache:clear');

		// Seed
		$this->call(CurrenciesTableSeeder::class);
		$this->call(CountriesTableSeeder::class);
		$this->call(LanguagesTableSeeder::class);
		$this->call(PermissionTypesTableSeeder::class);
		$this->call(PermissionsTableSeeder::class);
		$this->call(ProfilesTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(AuthprovidersTableSeeder::class);
		$this->call(AccountsTableSeeder::class);
		$this->call(OptionsTableSeeder::class);

		// Setup initial configuration
		Artisan::call('setup', [
		'--no-superuser' => null,
		'--currencies'   => 'USD,EUR',
		'--countries'    => 'USA,ESP',
		'--languages'    => 'en,es', // First in the list will be the default one
		]);

		/*
		 * To trigger this use either:
		 *
		 *	php artisan db:seed --env=local
		 *	php artisan migrate:refresh --seed --env=local
		 *
		 */
		if (app()->environment('local'))
		{
			$this->call(LocalEnvironmentSeeder::class);
		}

		// Restore mass-assign protection
		Model::reguard();
	}
}
