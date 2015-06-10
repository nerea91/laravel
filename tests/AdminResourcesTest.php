<?php

class AdminResourcesTest extends TestCase
{
	use Illuminate\Foundation\Testing\DatabaseTransactions;

	protected function resource($resource, array $input, array $except = [])
	{
		$user = $this->getSuperUser();
		$page = route("admin.$resource.create");
		$button = _('Add');
		$data = array_except($input, $except);

		$this
		->actingAs($user)
		->visit($page)
		->submitForm($button, $input)
		//->seePageIs(route("admin.$resource.show", [(int) DB::table($resource)->max('id')]))
		->assertSessionHasNoErrors($resource)
		->seeInDatabase($resource, $data);

		return $this;
	}

	public function testCurrency()
	{
		$this->resource('currencies', [
			'name' => 'Pesetas',
			'code' => 'PTS',
			'symbol_position' => 1,
			'decimal_separator' => '.',
		]);
	}

// 	public function testCountry()
// 	{
// 		$this->markTestIncomplete('This test works only when executed alone'); // TODO
//
// 		$this->resource('countries', [
// 			'name' => 'Wonderland',
// 			'iso_3166_2' => 'WL',
// 			'iso_3166_3' => 'WLD',
// 			'code' => '000',
// 			'eea' => 0,
// 		]);
// 	}

	public function testLanguage()
	{
		$this->resource('languages', [
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
		$this->resource('profiles', [
			'name' => 'Tester',
			'permissions' => range(10, 13)
		], ['permissions']);
	}

// 	public function testUser()
// 	{
// 		$this->markTestIncomplete('This test works only when executed alone'); // TODO
//
// 		$password = str_random(15);
//
// 		$this->resource('users', [
// 			'username' => 'tester',
// 			'password' => $password,
// 			'password_confirmation' => $password,
// 			'profile_id' => 2,
// 		], ['password', 'password_confirmation']);
// 	}

	public function testAuthProvider()
	{
		$this->resource('authproviders', [
			'name' => 'foo',
			'title' => 'Foo'
		]);
	}

	public function testAccount()
	{
		$account = $this->createNonNativeAccount($this->getSuperUser());
		$account->delete();

		$input = [
			'uid' => $account->uid,
			'provider_id' => $account->provider_id,
			'user_id' => $account->user_id,
		];

		// Create a new account from the same provider, this time using HTTP
		$this->notSeeInDatabase('accounts', $input)->resource('accounts', $input);
	}

	public function testDocument()
	{
		$this->resource('documents', [
			'title' => 'Tester',
			'body' => 'Testing',
			'profiles' => [1, 2]
		], ['profiles']);
	}
}
