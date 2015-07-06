<?php

/** NOTE: For a list of available helpers see docs/testing.md */

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__ . '/../bootstrap/app.php';

		$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

		// Set the base URL to use while testing the application
		$this->baseUrl = $app->config->get('app.url');

		// Set application language
		App\Language::detect()->apply();

		return $app;
	}

	/**
	 * Seed multiple seeds with one call.
	 *
	 * @param  dynamic
	 *
	 * @return $this
	 */
	protected function seeds()
	{
		foreach(func_get_args() as $seed)
			$this->seed($seed);

		return $this;
	}

	/**
	 * Get admin user from database.
	 *
	 * @return App\User
	 * @throws Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	protected function getSuperUser()
	{
		return App\User::findOrFail(1);
	}

	/**
	 * Dump last response of the crawler.
	 *
	 * @param  string $response
	 *
	 * @return $this
	 */
	public function dump($response = null)
	{
		fwrite(STDOUT, ($response) ?: $this->response->getContent() . "\n");

		return $this;
	}

	/**
	 * Fill the form with the given data.
	 *
	 * NOTE: This method is the same than the parent one (Illuminate\Foundation\Testing\CrawlerTrait)
	 * but allowing setting invalid values in choice fields (select, radio, checkbox).
	 *
	 * @param  string $buttonText
	 * @param  array  $inputs
	 *
	 * @return \Symfony\Component\DomCrawler\Form
	 */
	protected function fillForm($buttonText, $inputs = [])
	{
		if ( ! is_string($buttonText)) {
			$inputs = $buttonText;

			$buttonText = null;
		}

		return $this->getForm($buttonText)->disableValidation()->setValues($inputs);
	}

	/**
	 * Assert session has no errors.
	 *
	 * @param  string
	 *
	 * @return $this
	 */
	protected function assertSessionHasNoErrors($label = null)
	{
		$session = $this->app['session.store'];

		if($session->has('errors'))
		{
			$errors = $session->get('errors', new Illuminate\Support\MessageBag)->all();
			$this->assertEmpty($errors, "$label has errors: " . print_r($errors, true));
		}

		return $this;
	}

	/**
	 * Create an account of a non native provider
	 *
	 * @param  App\User
	 * @return App\Account
	 */
	protected function createNonNativeAccount(App\User $user)
	{
		// Create non native provider
		$provider = App\AuthProvider::create([
			'name' => 'testing',
			'title' => 'Testing provider'
		]);

		// Create account
		$data = [
			'provider_id' => $provider->getKey(),
			'user_id' => $user->getKey(),
			'uid' => 666,
		];
		$account = App\Account::create($data);

		// Make sure the account is from a non native provider
		$this
		->seeInDatabase('accounts', $data)
		->assertGreaterThan(1, $account->provider_id);

		return $account;
	}


	/**
	 * Remove Eloquent Model events and create them again.
	 * Workaround for BUG https://github.com/laravel/framework/issues/1181
	 *
	 * @param  dynamic
	 *
	 * @return $this
	 */
	protected function resetModelEvents()
	{
		$models = func_get_args();

		foreach($models as $model)
		{
			// Flush any existing listeners.
			call_user_func(array($model, 'flushEventListeners'));

			// Reregister them.
			call_user_func(array($model, 'boot'));
		}

		return $this;
	}
}
