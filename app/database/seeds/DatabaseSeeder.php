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

		$this->call('CountriesTableSeeder');
		//$this->call('UserTableSeeder');
		$this->call('LanguagesTableSeeder');
	}

}
