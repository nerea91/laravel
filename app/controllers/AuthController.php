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
		$validator = Validator::make(
			$input = Input::only(['username', 'password', 'remember']),
			[
				'username' => 'required|max:64|alpha_num',
				'password' => 'required|min:5|max:80',
			]
		);

		$validator->setAttributeNames(['username' => _('Username'), 'password' => _('Password')]);

		if($validator->passes())
		{
			if(Auth::attempt(array_except($input, 'remember'), Input::has('remember')))
				return Redirect::intended('/');

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
		return Redirect::to('/');
	}

}
