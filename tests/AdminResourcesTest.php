<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminResourcesTest extends TestCase
{
	// Rollback the database after each test and migrate it before the next test.
	use DatabaseMigrations;

	/**
	 * Test a resource controller.
	 *
	 * @param  string $resource Name of the resource route/table
	 * @param  array  $input
	 * @return $this
	 */
	protected function resource($resource, array $input)
	{
		$expectedDatabaseId = (int) DB::table($resource)->max('id') + 1;
		$expectedDatabaseData = array_except($input, ['password', 'password_confirmation']);

		$user = $this->getSuperUser();
		$formPage = route("admin.$resource.create");
		$formButton = _('Add');
		$successPage = route("admin.$resource.show", [$expectedDatabaseId]);

		$this
		->actingAs($user)
		->visit($formPage)
		->submitForm($formButton, $input)
		->assertSessionHasNoErrors($resource)
		->seePageIs($successPage)
		->seeInDatabase($resource, $expectedDatabaseData);

		return $this;
	}

	protected function seedPermissions()
	{
		return $this->seeds('LanguagesTableSeeder', 'PermissionTypesTableSeeder', 'PermissionsTableSeeder', 'ProfilesTableSeeder', 'UsersTableSeeder');
	}

	public function testCurrency()
	{
		$this
		->seedPermissions()
		->resource('currencies', [
			'name' => 'Pesetas',
			'code' => 'PTS',
			'symbol_position' => 1,
			'decimal_separator' => '.',
		]);
	}

	public function testCountry()
	{
		$this
		->seedPermissions()
		->resource('countries', [
			'name' => 'Wonderland',
			'iso_3166_2' => 'WL',
			'iso_3166_3' => 'WLD',
			'code' => 666,
			'eea' => 0,
		]);
	}

	public function testLanguage()
	{
		$this
		->seedPermissions()
		->resource('languages', [
			'code' => 'vy',
			'name' => 'Valyrian',
			'english_name' => 'Valyrian',
			'locale' => 'vy_GT',
			'is_default' => 0,
			'priority' => 666,
		]);
	}

	public function testProfile()
	{
		$this->markTestIncomplete('Waiting until BUG https://github.com/laravel/framework/issues/9052 gets fixed'); // TODO

		$this
		->seedPermissions()
		->resource('profiles', [
			'name' => 'Tester',
			'permissions' => range(10, 13)
		]);
	}

	public function testUser()
	{
		$this
		->seedPermissions()
		->resource('users', [
			'username' => 'tester',
			'password' => 'secret',
			'password_confirmation' => 'secret',
			'profile_id' => 1,
		]);
	}

	public function testAuthProvider()
	{
		$this
		->seedPermissions()
		->resource('authproviders', [
			'name' => 'foo',
			'title' => 'Foo'
		]);
	}

	public function testAccount()
	{
		$provider = App\AuthProvider::create(['name' => 'foo', 'title' => 'Foo']);
		$this->assertEquals($provider->getKey(), 1);

		$this
		->seedPermissions()
		->resource('accounts', [
			'uid' => 666,
			'provider_id' => $provider->getKey(),
			'user_id' => 1,
		]);
	}

	public function testDocument()
	{
		$this->markTestIncomplete('Waiting until BUG https://github.com/laravel/framework/issues/9052 gets fixed'); // TODO

		$this
		->seedPermissions()
		->resource('documents', [
			'title' => 'Tester',
			'body' => 'Testing',
			'profiles' => [1, 2]
		]);
	}
}
