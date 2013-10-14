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
	 * Attempts to log in an user into the native authentication
	 *
	 * @return Response
	 */
	public function doLogin()
	{
		$input = Input::all();

		$validator = Validator::make($input, [
			'username' => 'required|max:64|alpha_num',
			'password' => 'required|min:5',
		]);

		if($validator->passes())
		{
			if(Auth::attempt(['username' => $input['username'], 'password' => $input['password']], Input::has('remember'))) //to-do se acuerda del login siempre auqnue no se marque el checkbox
				return Redirect::intended('/');

			//to-do flash mensaje informando credenciales incorrectos. hacer que el layout mustre los mensajes flash
		}
		return Redirect::back()->withInput(Input::except('password'))->withErrors($validator);
	}

	/**
	 * Logs out an user from the native authentication
	 *
	 * @return Response
	 */
	public function doLogout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

}
