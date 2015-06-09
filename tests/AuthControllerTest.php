<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthControllerTest extends TestCase
{
	// Rollback the database after each test and migrate it before the next test.
	use DatabaseMigrations;

	public function testLoginPage()
	{
		$this->assertFalse(Auth::check());

		$this
		->seeds('ProfilesTableSeeder', 'UsersTableSeeder', 'AuthprovidersTableSeeder', 'AccountsTableSeeder')
		->visit(route('login'))
		->submitForm($button = _('Login'), [
			'username' => 'admin',
			'password' => 'secret'
		])
		->assertTrue(Auth::check());
	}

	public function testLogoutPage()
	{
		$this
		->seeds('ProfilesTableSeeder', 'UsersTableSeeder') // Required because Auth::logout() will try to update remember token
		->actingAs(App\User::firstOrFail())
		->assertTrue(Auth::check());

		$this
		->visit(route('logout'))
		->seePageIs(route('home'))
		->assertFalse(Auth::check());
	}
}
