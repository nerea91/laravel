<?php

class UserPanelController extends BaseController {

	protected $layout = 'layouts.admin';

	/**
	 * Show form for changing current user options.
	 *
	 * @return Response
	 */
	public function showSettingsForm()
	{
		$this->layout->title = _('User panel');
		$this->layout->subtitle = _('Options');
		$this->layout->content = View::make('userpanel.options')->with('user', Auth::user());
	}

	/**
	 * Show form for changing current user password.
	 *
	 * @return Response
	 */
	public function showChangePasswordForm()
	{
		$this->layout->title = _('User panel');
		$this->layout->subtitle = _('Password');
		$this->layout->content = View::make('userpanel.password')->with('user', Auth::user());
	}

	/**
	 * Change current user password.
	 *
	 * @return Response
	 */
	public function updatePassword()
	{
		$labels = array(
			'current_password'	=> _('Current password'),
			'password'	=> _('New password'),
			'password_confirmation' => _('Repeat password'),
		);

		$input = Input::only(array_keys($labels));
		$user = Auth::user();

		$rules = $user->resetRule('password', 'different')->getRules();
		$rules = array(
			'current_password'		=> 'required',
			'password'				=> $rules['password'],
			'password_confirmation'	=> 'required',
		);

		$validator = Validator::make($input, $rules)->setAttributeNames($labels);

		// Validate form
		if($validator->fails())
			return Redirect::back()->withInput($input)->withErrors($validator);

		// Check old credentials
		if( ! Auth::validate(['username' => $user->username, 'password' => $input['current_password']]))
		{
			$validator->messages()->add('current_password', _('Wrong password'));
			return Redirect::back()->withInput($input)->withErrors($validator);
		}

		$user->resetRule('password', 'confirmed');
		$user->password = Hash::make($input['password']);
		$user->save();

		return Redirect::back()->withSuccess(_('Password updated'));

	}
}
