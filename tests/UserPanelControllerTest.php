<?php

class UserPanelControllerTest extends TestCase
{
	use Illuminate\Foundation\Testing\DatabaseTransactions;

	public function testUpdateOptions()
	{
		// Route
		$user = $this->getSuperUser();
		$page = route('user.options');

		// Form
		$button = _('Save');
		$input = ['admin_panel_results_per_page' => 5];

		// Database
		$table = 'option_user';
		$data = ['option_id' => 1, 'user_id' => $user->getKey(), 'value' => 5];

		// Test
		$this
		->missingFromDatabase($table, $data)
		->actingAs($user)
		->visit($page)
		->submitForm($button, $input)
		->seePageIs($page)
		->assertSessionHasNoErrors()
		->seeInDatabase($table, $data);
	}

	public function testUpdatePassword()
	{
		// Route
		$user = $this->getSuperUser();
		$page = route('user.password');

		// Form
		$button = _('Change password');
		$input = [
			'current_password' => 'secret',
			'password' => 'secret',
			'password_confirmation' => 'secret'
		];

		// Database
		$originalPassword = $user->password;

		// Test
		$this
		->actingAs($user)
		->visit($page)
		->submitForm($button, $input)
		->seePageIs($page)
		->assertSessionHasNoErrors()
		->assertNotEquals($originalPassword, $this->getSuperUser()->password);
	}

	public function testUpdateRegional()
	{
		// Route
		$user = $this->getSuperUser();
		$page = route('user.regional');

		// Form
		$button = _('Save');
		$input = [
			'country_id' => App\Country::firstOrFail()->getKey(),
			'language_id' => App\Language::firstOrFail()->getKey(),
		];

		// Database
		$table = 'users';
		$data = $input + ['id' => $user->getKey()];

		// Test
		$this
		->missingFromDatabase($table, $data)
		->actingAs($user)
		->visit($page)
		->submitForm($button, $input)
		->seePageIs($page)
		->assertSessionHasNoErrors()
		->seeInDatabase($table, $data);
	}

	public function testUpdateAccounts()
	{
		$page = route('user.accounts');
		$button = _('Revoke access');
		$user = $this->getSuperUser();
		$account = $this->createNonNativeAccount($user);
		$data = array_except($account->toArray(), ['created_at', 'updated_at']);

		$this
		->actingAs($user)
		->visit($page)
		->see($account->provider->title)
		->press($button)
		->seePageIs($page)
		->see($account->provider->title, true) // AKA Not see
		->see(_('Account access has been revoked'))
		->notSeeInDatabase('accounts', $data);
	}
}
