<?php

class AuthController extends BaseController {

	protected $layout = 'layouts.base';

	/**
	 * Display the login form for native authentication.
	 *
	 * @return Response
	 */
	public function showLoginForm()
	{
		$this->layout->title = _('Login');
		$this->layout->content = View::make('auth.login_form');
	}

	/**
	 * Attempt to log in an user using native authentication
	 *
	 * @return Response
	 */
	public function doLogin()
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
				Event::fire('account.login', array(Auth::user()->accounts()->where('provider_id', 1)->first()));
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
	public function doLogout()
	{
		Auth::logout();
		Session::flush();
		return Redirect::to('/');
	}

}
