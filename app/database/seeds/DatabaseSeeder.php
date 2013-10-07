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
		$this->call('LanguagesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('PhonesTableSeeder');
		$this->call('TagsTableSeeder');
		$this->call('PostsTableSeeder');
	}

}
