<?php

class AuthControllerTest extends TestCase
{
	use Illuminate\Foundation\Testing\DatabaseTransactions;

	public function testLoginPage()
	{
		$this->assertFalse(Auth::check());

		$this
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
		->actingAs($this->getSuperUser())
		->assertTrue(Auth::check());

		$this
		->visit(route('logout'))
		->seePageIs(route('home'))
		->assertFalse(Auth::check());
	}
}
