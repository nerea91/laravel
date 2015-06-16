<?php

class AdminResourcesTest extends TestCase
{
	use Illuminate\Foundation\Testing\DatabaseTransactions;

	/** Helper methods **/

	protected function resource($resource)
	{
		$this->resource = $resource;

		return $this;
	}

	protected function table($table)
	{
		$this->table = $table;

		return $this;
	}

	// Test resource creation via HTTP
	protected function create(array $input, array $except = [])
	{
		$user = $this->getSuperUser();
		$route = $this->resource;
		$page = route("admin.$route.create");
		$button = _('Add');
		$table = (isset($this->table)) ? $this->table : $route;
		$data = array_except($input, $except);

		$this
		->actingAs($user)
		->visit($page)
		->submitForm($button, $input)
		->seePageIs(route("admin.$route.show", [(int) DB::table($table)->max('id')]))
		->assertSessionHasNoErrors($route)
		->seeInDatabase($table, $data);

		return $this;
	}

	/** Functional tests */

	public function testCreateCurrency()
	{
		$this
		->resource('currencies')
		->create([
			'name' => 'Pesetas',
			'code' => 'PTS',
			'symbol_position' => 1,
			'decimal_separator' => '.',
		]);
	}

	public function testCreateCountry()
	{
		$this
		->resource('countries')
		->create([
			'name' => 'Wonderland',
			'iso_3166_2' => 'WL',
			'iso_3166_3' => 'WLD',
			'code' => '000',
			'eea' => 0,
			'currency_id' => 50,
		]);
	}

	public function testCreateLanguage()
	{
		$this
		->resource('languages')
		->create([
			'code' => 'vy',
			'name' => 'Valyrian',
			'english_name' => 'Valyrian',
			'locale' => 'vy_GT',
			'is_default' => 0,
			'priority' => 666,
		]);
	}

	public function testCreateProfile()
	{
		$this
		->resource('profiles')
		->create([
			'name' => 'Tester',
			'permissions' => range(10, 13)
		], ['permissions']);
	}

// 	public function testCreateUser()
// 	{
// 		$this->markTestIncomplete('This test works only when executed alone'); // TODO
//
// 		$password = str_random(15);
//
// 		$this
// 		->resource('users')
//		->create([
// 			'username' => 'tester',
// 			'password' => $password,
// 			'password_confirmation' => $password,
// 			'profile_id' => 2,
// 		], ['password', 'password_confirmation']);
// 	}

	public function testCreateAuthProvider()
	{
		$this
		->resource('authproviders')
		->create([
			'name' => 'foo',
			'title' => 'Foo'
		]);
	}

	public function testCreateAccount()
	{
		$account = $this->createNonNativeAccount($this->getSuperUser());
		$account->delete();

		$input = [
			'uid' => $account->uid,
			'provider_id' => $account->provider_id,
			'user_id' => $account->user_id,
		];

		$this
		->notSeeInDatabase('accounts', $input)
		->resource('accounts')
		->create($input);
	}

	public function testCreateDocument()
	{
		$this
		->resource('documents')
		->create([
			'title' => 'Tester',
			'body' => 'Testing',
			'profiles' => [1, 2]
		], ['profiles']);
	}

	#_RESOURCE_GENERATOR_MARKER_#_DO_NOT_REMOVE_#
}
