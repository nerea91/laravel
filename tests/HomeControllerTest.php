<?php

class HomeControllerTest extends TestCase
{
	public function testShowMainPage()
	{
		$this
		->visit(route('home'))
		->see(config('site.name'))
		->see(_('Home'))
		->see(_('Login'));
	}

	/*public function testChangePageLanguage()
	{
		$this->markTestIncomplete('This test has not been implemented yet'); // TODO

		$this
		->visit(route('home'))
		->see('Home')
		->visit(route('language.set', ['es']))
		->see('Inicio');
	}*/

	public function testSendContactEmail()
	{
		// Make sure the mail service provider is enabled.
		$this->assertContains(Illuminate\Mail\MailServiceProvider::class, config('app.providers'));

		$this
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
