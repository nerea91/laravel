<?php namespace App\Http\Controllers;

use App\AuthProvider;
use App\Exceptions\OauthException;
use Config;
use Input;
use Session;
use Socialite;
use URL;
use Validator;

class AuthController extends Controller
{
	protected $layout = 'layouts.master';

	/**
	 * Display the login form.
	 *
	 * @return Response
	 */
	public function showLoginForm()
	{
		// Add data to the layout
		$this->layout->title = _('Login');

		// Add data to the view
		$view = view('home.login')->withProviders(AuthProvider::getUsable());

		// Return layout + view
		return $this->layout($view);
	}

	/**
	 * Attempt to log in an user using native authentication.
	 *
	 * @return Response
	 */
	public function login()
	{
		$input = Input::only(['username', 'password', 'remember']);

		$rules = [
			'username' => 'required|min:4|max:32|alpha_num',
			'password' => 'required|min:5|max:80',
		];

		$validator = Validator::make($input, $rules);

		$validator->setAttributeNames(['username' => _('Username'), 'password' => _('Password')]);

		if($validator->passes())
		{
			if(auth()->attempt(array_except($input, 'remember'), Input::has('remember')))
			{
				event('account.login', [auth()->user()->accounts()->where('provider_id', 1)->first()]);

				return redirect()->intended('/');
			}

			Session::flash('error', _('Wrong credentials'));
		}

		return redirect()->back()->withInput(array_except($input, 'password'))->withErrors($validator);
	}

	/**
	 * Log out the current user
	 *
	 * @return Response
	 */
	public function logout()
	{
		auth()->logout();
		Session::flush();

		return redirect()->route('home');
	}

	/**
	 * Attempt to log in an user using an Oauth authentication provider.
	 *
	 * @param  string
	 *
	 * @return Response
	 */
	public function oauthLogin($providerName)
	{
		try
		{
			// If the remote provider sends an error cancel the process
			foreach(['error', 'error_message', 'error_code'] as $error)
				if(Input::has($error))
					throw new OauthException(_('Something went wrong') . '. ' . Input::get($error));

			// Check if provider exists
			if( ! $provider = AuthProvider::whereName($providerName)->first() or ! $provider->isUsable())
				throw new OauthException(sprintf(_('Unknown provider: %s'), e($providerName)));

			// Set provider callback url
			Config::set("services.{$provider->name}.redirect", URL::current());

			// Create an Oauth service for this autentication provider
			if( ! $oauthService = Socialite::with($provider->name))
				throw new OauthException(sprintf('Provider %s has no Oauth implementation', $provider));

			// Oauth 2
			if($oauthService instanceof \Laravel\Socialite\Two\AbstractProvider)
			{
				// Check if current request is a callback from the provider
				if(Input::has('code'))
					return $this->loginSocialUser($provider, $oauthService->user());

				// If we have configured custom scopes use them
				if($scopes = config("services.{$provider->slug}.scopes"))
					$oauthService->scopes($scopes);
			}
			// Oauth 1
			else
			try
			{
				// Check if current request is a final callback from the provider
				if($user = $oauthService->user())
					return $this->loginSocialUser($provider, $user);
			}
			catch(\InvalidArgumentException $e)
			{
				// This is not the final callback.
				// As both Oauth 1 and Oauth 2 need redirecting at this
				// point the redirection is done outside the 'catch' block.
			}

			// Request user to authorize our App
			return $oauthService->redirect();
		}
		catch(OauthException $e)
		{
			Session::flash('error', $e->getMessage());

			return redirect()->route('login');
		}
	}

	/**
	 * Handle callback from provider.
	 *
	 * It creates/gets the user account and logs him/her in.
	 *
	 * @param  \App\AuthProvider
	 * @param  \Laravel\Socialite\Contracts\User
	 *
	 * @return Response
	 * @throws OauthException
	 */
	protected function loginSocialUser(AuthProvider $provider, \Laravel\Socialite\Contracts\User $socialUser)
	{
		// Get/create associated account
		$account = $provider->findOrCreateAccount($socialUser);

		// Do not ley disabled user to log in
		if($account->user->trashed())
			throw new OauthException(_('This account has been disabled'));

		// Login user
		auth()->login($account->user);

		// Fire account login event
		event('account.login', [$account]);

		return redirect()->intended('/');
	}
}
