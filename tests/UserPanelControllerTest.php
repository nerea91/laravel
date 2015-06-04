<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserPanelControllerTest extends TestCase
{
	// Rollback the database after each test and migrate it before the next test.
	use DatabaseMigrations;

	public function testUpdateOptions()
	{
		$this->seeds('LanguagesTableSeeder', 'ProfilesTableSeeder', 'UsersTableSeeder', 'OptionsTableSeeder');

		$user = $this->getSuperUser();
		$page = route('user.options');
		$rightInput = ['admin_panel_results_per_page' => 5];
		$wrongInput = ['admin_panel_results_per_page' => 0];
		$expectedDatabaseData = ['id' => 1, 'option_id' => 1, 'user_id' => $user->getKey(), 'value' => 5];

		// Test right input
		$this
		->actingAs($user)
		->visit($page)
		->submitForm(_('Save'), $rightInput)
		->assertSessionHasNoErrors()
		->seePageIs($page)
		->seeInDatabase('option_user', $expectedDatabaseData);

		// Test wrong input
		$this
		->actingAs($user)
		->visit($page)
		->submitForm(_('Save'), $wrongInput)
		->seePageIs($page)
		->seeInDatabase('option_user', $expectedDatabaseData)
		->assertSessionHasErrors();
	}

	public function testUpdatePassword()
	{
		$this->seeds('LanguagesTableSeeder', 'ProfilesTableSeeder', 'UsersTableSeeder');

		$user = $this->getSuperUser();
		$originalPassword = $user->password;
		$page = route('user.password');
		$formButton = _('Change password');
		$formInput = [
			'current_password' => 'secret',
			'password' => 'secret',
			'password_confirmation' => 'secret'
		];

		$this
		->actingAs($user)
		->visit($page)
		->submitForm($formButton, $formInput)
		->seePageIs($page)
		->assertSessionHasNoErrors()
		->assertNotEquals($originalPassword, $this->getSuperUser()->password);
	}

	public function testUpdateRegional()
	{
		$this->seeds('CountriesTableSeeder', 'LanguagesTableSeeder', 'ProfilesTableSeeder', 'UsersTableSeeder');

		$user = $this->getSuperUser();
		$page = route('user.regional');
		$formButton = _('Save');
		$formInput = [
			'country_id' => App\Country::firstOrFail()->getKey(),
			'language_id' => App\Language::firstOrFail()->getKey(),
		];
		$expectedDatabaseData = $formInput + ['id' => $user->getKey()];

		$this
		->actingAs($user)
		->visit($page)
		->submitForm($formButton, $formInput)
		->seePageIs($page)
		->assertSessionHasNoErrors()
		->seeInDatabase('users', $expectedDatabaseData);
	}
}
