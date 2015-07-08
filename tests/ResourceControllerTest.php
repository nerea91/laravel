<?php

class ResourceControllerTest extends TestCase
{
	use ResourceControllerTrait, Illuminate\Foundation\Testing\DatabaseTransactions;

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

	public function testDeleteAccount()
	{
		$account = $this->createNonNativeAccount($this->getSuperUser());

		$this->resource('accounts')->destroy($account->getKey());
	}

	public function testCreateAuthProvider()
	{
		$this
		->resource('authproviders')
		->create([
			'name' => 'foo',
			'title' => 'Foo'
		]);
	}

	public function testDeleteAuthProvider()
	{
		$account = $this->createNonNativeAccount($this->getSuperUser());

		$this->resource('authproviders')->destroy($account->provider->getKey());
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

	public function testDeleteCountry()
	{
		$this->resource('countries')->destroy(724); // Spain
	}

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

	public function testDeleteCurrency()
	{
		$this->resource('currencies')->destroy(50); // €
	}

	public function testCreateDocument()
	{
		$this
		->resource('documents')
		->relationships('profiles')
		->create([
			'title' => 'Tester',
			'body' => 'Testing',
			'profiles' => [1, 2]
		]);
	}

	public function testDeleteDocument()
	{
		$resource = App\Document::create([
			'title' => 'Tester',
			'body' => 'Testing',
		]);

		$this->resource('documents')->destroy($resource->getKey());
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

	public function testDeleteLanguage()
	{
		// First non-default language
		$resource = App\Language::whereIsDefault(0)->firstOrFail();

		$this->resource('languages')->destroy($resource->getKey());
	}

	public function testCreateProfile()
	{
		$this
		->resource('profiles')
		->relationships('permissions')
		->create([
			'name' => 'Tester',
			'permissions' => range(10, 13)
		]);
	}

	public function testDeleteProfile()
	{
		$this->resource('profiles')->destroy(2);
	}

	public function testCreateUser()
	{
		$this
		->resource('users')
		->relationships('password', 'password_confirmation')
		->resetModelEvents('App\User') // Workaround for BUG 1181
		->create([
			'username' => 'tester',
			'password' => $password = str_random(15),
			'password_confirmation' => $password,
			'profile_id' => 2,
		]);
	}

	public function testDeleteUser()
	{
		$this->resetModelEvents('App\User'); // Workaround for BUG 1181

		$resource = App\User::create([
			'username' => 'tester',
			'name' => 'tester',
			'password' => $password = str_random(15),
			'password_confirmation' => $password,
			'profile_id' => 2,
		]);

		$this->resource('users')->destroy($resource->getKey());
	}

	#_RESOURCE_GENERATOR_MARKER_#_DO_NOT_REMOVE_#
}
