<?php namespace App\Http\Controllers;

class AuthController extends BaseController
{
	protected $layout = 'layouts.master';

	/**
	 * Display the login form.
	 *
	 * @return Response
	 */
	public function showLoginForm()
	{
		$this->layout->title = _('Login');
		$this->layout->content = View::make('home.login')->withProviders(AuthProvider::getUsable());
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
			if(Auth::attempt(array_except($input, 'remember'), Input::has('remember')))
			{
				Event::fire('account.login', [Auth::user()->accounts()->where('provider_id', 1)->first()]);
				return Redirect::intended('/');
			}

			Session::flash('error', _('Wrong credentials'));
		}
		return Redirect::back()->withInput(array_except($input, 'password'))->withErrors($validator);
	}

	/**
	 * Log out the current user
	 *
	 * @return Response
	 */
	public function logout()
	{
		Auth::logout();
		Session::flush();
		return Redirect::route('home');
	}

	/**
	 * Attempt to log in an user using an Oauth authentication provider.
	 *
	 * @param  string
	 * @return Response
	 */
	public function oauthLogin($providerName)
	{
		try
		{
			// Check if provider exists
			if( ! $provider = AuthProvider::whereName($providerName)->first() and $provider->isUsable())
				throw new OauthException(sprintf(_('Unknown provider: %s'), e($providerName)));

			// Create an Oauth service for this autentication provider
			if( ! $oauthService = OAuth::service($provider->name))
				throw new OauthException(sprintf('Provider %s has no Oauth implementation', $provider));

			// If the user does not accept our App cancell the process
			if(Input::get('error') === 'access_denied')
				throw new OauthException(_('Cancelled by user'));

			// Request user to authorize our App
			if( ! Input::has('code'))
				return Redirect::to(htmlspecialchars_decode($oauthService->getAuthorizationUri()));

			//This was a callback request from the Oauth service

			// Request Access Token
			$token = $oauthService->requestAccessToken(Input::get('code'));

			// Get/create associated account
			$account = $provider->findOrCreateAccount($oauthService);

			// Do not allow login to users that have been disabled
			if($account->user->trashed())
				throw new OauthException(_('This account has been disabled'));

			// Login user
			Auth::login($account->user);

			// Fire account login event to save token
			$account->access_token = Crypt::encrypt($token->getAccessToken());
			Event::fire('account.login', [$account]);

			return Redirect::intended('/');
		}
		catch(OauthException $e)
		{
			Session::flash('error', $e->getMessage());
			return Redirect::route('login');
		}
		catch(OAuth\Common\Http\Exception\TokenResponseException $e)
		{
			Session::flash('error', $e->getMessage());
			return Redirect::route('login');
		}
	}
}
