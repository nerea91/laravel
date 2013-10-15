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
		$data = array(
			'title' => _('Login'),
		);

		$this->layout->content = View::make('auth.login_form', $data);
	}

	/**
	 * Attempts to log in an user using native authentication
	 *
	 * @return Response
	 */
	public function doLogin()
	{
		$input = Input::only(['username', 'password', 'remember']);

		$validator = Validator::make($input, [
			'username' => 'required|max:64|alpha_num',
			'password' => 'required|min:5',
		]);

		if($validator->passes())
		{
			if(Auth::attempt(array_except($input, 'remember'), Input::has('remember'))) //to-do se acuerda del login siempre auqnue no se marque el checkbox
				return Redirect::intended('/');

			Session::flash('message', _('Wrong credentials'));
		}
		return Redirect::back()->withInput(array_except($input, 'password'))->withErrors($validator);
	}

	/**
	 * Logs out an user
	 *
	 * @return Response
	 */
	public function doLogout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

}
