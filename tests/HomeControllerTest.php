<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeControllerTest extends TestCase
{
	// Rollback the database after each test and migrate it before the next test.
	use DatabaseMigrations;

	public function testShowMainPage()
	{
		$this
		->seeds('LanguagesTableSeeder')
		->visit(route('home'))
		->see(config('site.name'))
		->see(_('Home'))
		->see(_('Login'));
	}

	public function testChangePageLanguage()
	{
		$this->markTestIncomplete('This test has not been implemented yet'); // TODO

		$this
		->seeds('LanguagesTableSeeder')
		->visit(route('home'))
		->see('Home')
		->visit(route('language.set', ['es']))
		->see('Inicio');
	}

	public function testSendContactEmail()
	{
		// Make sure the mail service provider is enabled.
		$this->assertContains('Illuminate\Mail\MailServiceProvider', config('app.providers'));

		$this->seeds('LanguagesTableSeeder')
		->visit(route('contact'))
		->submitForm($button = _('Send query'), [
			'name' => 'foo',
			'email' => 'foo@example.com',
			'message' => 'Testing contact page',
		])
		->see(_('Your query has been sent!'))
		->onPage(route('contact'));
	}
}
