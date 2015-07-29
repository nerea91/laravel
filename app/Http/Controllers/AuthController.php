<?php namespace App\Http\Controllers;

use App\AuthProvider;
use App\Exceptions\OauthException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Socialite;
use URL;
use Validator;

class AuthController extends Controller
{
	use ThrottlesLogins;

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
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Response
	 */
	public function login(Request $request)
	{
		// Check if there are too many login attempts for current username and IP
		$this->incrementLoginAttempts($request);
		if($this->hasTooManyLoginAttempts($request))
			return $this->sendLockoutResponse($request);

		// Validate form
		$credentials = $request->only('username', 'password');
		$rules = [
			'username' => 'required|min:4|max:32|alpha_num',
			'password' => 'required|min:5|max:80',
		];
		$validator = Validator::make($credentials, $rules)->setAttributeNames(['username' => _('Username'), 'password' => _('Password')]);

		if($validator->passes())
		{
			// Attempt login
			if(auth()->attempt($credentials, $request->has('remember')))
			{
				$this->clearLoginAttempts($request);

				// Increment native account login count
				$account = auth()->user()->accounts()->whereProviderId(1)->firstOrFail();
				event('account.login', [$account]);

				return redirect()->intended(route('home'));
			}

			$request->session()->flash('error', _('Wrong credentials'));
		}

		// Wrong form data or credentials
		return redirect()->back()->withInput($request->except('password'))->withErrors($validator);
	}

	/**
	 * Attempt to log in an user using an Oauth authentication provider.
	 *
	 * @param Illuminate\Http\Request $request
	 * @param  string
	 *
	 * @return Response
	 */
	public function oauthLogin(Request $request, $providerName)
	{
		// Check if there are too many login attempts for current username and IP
		$this->incrementLoginAttempts($request);
		if($this->hasTooManyLoginAttempts($request))
			return $this->sendLockoutResponse($request);

		try
		{
			// If the remote provider sends an error cancel the process
			foreach(['error', 'error_message', 'error_code'] as $error)
				if($request->has($error))
					throw new OauthException(_('Something went wrong') . '. ' . $request->get($error));

			// Check if provider exists
			if( ! $provider = AuthProvider::whereName($providerName)->first() or ! $provider->isUsable())
				throw new OauthException(sprintf(_('Unknown provider: %s'), e($providerName)));

			// Set provider callback url
			\Config::set("services.{$provider->name}.redirect", URL::current());

			// Create an Oauth service for this autentication provider
			if( ! $oauthService = Socialite::with($provider->name))
				throw new OauthException(sprintf('Provider %s has no Oauth implementation', $provider));

			// Oauth 2
			if($oauthService instanceof \Laravel\Socialite\Two\AbstractProvider)
			{
				// Check if current request is a callback from the provider
				if($request->has('code'))
					return $this->loginSocialUser($provider, $oauthService->user(), $request);

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
					return $this->loginSocialUser($provider, $user, $request);
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
			$request->session()->flash('error', $e->getMessage());

			return redirect()->route('login');
		}
	}

	/**
	 * Log out the current user
	 *
	 * @param Illuminate\Http\Request $request
	 *
	 * @return Response
	 */
	public function logout(Request $request)
	{
		auth()->logout();
		$request->session()->flush();

		return redirect()->route('home');
	}

	/**
	 * Handle callback from oAuth provider.
	 *
	 * It creates/gets the user account and logs it in.
	 *
	 * @param  \App\AuthProvider
	 * @param  \Laravel\Socialite\Contracts\User
	 * @param  \Illuminate\Http\Request
	 *
	 * @return Response
	 * @throws OauthException
	 */
	protected function loginSocialUser(AuthProvider $provider, \Laravel\Socialite\Contracts\User $socialUser, Request $request)
	{
		// Get/create associated account
		$account = $provider->findOrCreateAccount($socialUser);

		// Do not let disabled user to log in
		if($account->user->trashed())
			throw new OauthException(_('This account has been disabled'));

		// Clear login attempts
		$this->clearLoginAttempts($request);

		// Login user
		auth()->login($account->user);

		// Fire account login event
		event('account.login', [$account]);

		return redirect()->intended('/');
	}

	/**
	 * Redirect the user after determining they are locked out.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendLockoutResponse(Request $request)
	{
		$seconds = (int) \Cache::get($this->getLoginLockExpirationKey($request)) - time();
		$message = sprintf(_('Too many login attempts. Please try again in %d seconds.'), $seconds);
		$request->session()->flash('error', $message);

		return redirect()->back()->withInput($request->except('password'));
	}

	/**
	 * Get the name of the attribute used to control login throttling.
	 *
	 * @return string
	 */
	protected function loginUsername()
	{
		return 'username';
	}
}
