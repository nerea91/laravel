<?php namespace App\Http\Controllers;

use App\AuthProvider;
use App\Exceptions\OauthException;
use Socialite;
use App\User;
use Auth;
use Crypt;
use Input;
use Session;
use Validator;
use View;

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
			if(Auth::attempt(array_except($input, 'remember'), Input::has('remember')))
			{
				event('account.login', [Auth::user()->accounts()->where('provider_id', 1)->first()]);
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
		Auth::logout();
		Session::flush();
		return redirect()->route('home');
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
			if( ! $provider = AuthProvider::whereName($providerName)->first() or ! $provider->isUsable())
				throw new OauthException(sprintf(_('Unknown provider: %s'), e($providerName)));

			// Create an Oauth service for this autentication provider
			if( ! $oauthService = Socialite::with($provider->name))
				throw new OauthException(sprintf('Provider %s has no Oauth implementation', $provider));

			// If the remote provider sends an error cancel the process
			if(Input::has('error'))
				throw new OauthException(_('Something went wrong') . '. ' . Input::get('error'));

			// Request user to authorize our App
			if( ! Input::has('code'))
			{
				// If we have condigured some scopes use them, otherwise use defaults
				$scopes = config("services.{$provider->name}.scopes");

				return ($scopes) ? $oauthService->scopes($scopes)->redirect() : $oauthService->redirect();
			}

			// == This was a callback request from the Oauth service ==

			// Get/create associated account
			$account = $provider->findOrCreateAccount($oauthService->user());

			// Do not allow login to users that have been disabled
			if($account->user->trashed())
				throw new OauthException(_('This account has been disabled'));

			// Login user
			Auth::login($account->user);

			// Fire account login event
			event('account.login', [$account]);

			return redirect()->intended('/');
		}
		catch(OauthException $e)
		{
			Session::flash('error', $e->getMessage());
			return redirect()->route('login');
		}
		catch(\InvalidArgumentException  $e)
		{
			Session::flash('error', $e->getMessage());
			return redirect()->route('login');
		}
	}
}
