<?php

class UserPanelController extends BaseController
{
	protected $layout = 'layouts.admin';

	/**
	 * Show form for changing current user options.
	 *
	 * @return Response
	 */
	public function showOptionsForm()
	{
		$this->layout->title = _('User panel');
		$this->layout->subtitle = _('Options');
		$this->layout->content = View::make('userpanel.options')->withOptions(Auth::user()->getAssignableOptions());
	}

	/**
	 * Change current user options.
	 *
	 * @return Response
	 */
	public function updateOptions()
	{
		$errors = Auth::user()->setOptions(Input::all());

		if($errors->any())
			return Redirect::back()->withInput()->withErrors($errors);

		return Redirect::back()->withSuccess(_('Options have been saved'));
	}

	/**
	 * Show form for changing current user password.
	 *
	 * @return Response
	 */
	public function showChangePasswordForm()
	{
		$this->layout->title = _('User panel');
		$this->layout->subtitle = _('Change password');
		$this->layout->content = View::make('userpanel.password')->with('user', Auth::user());
	}

	/**
	 * Change current user password.
	 *
	 * @return Response
	 */
	public function updatePassword()
	{
		$user = Auth::user();
		$user_rules = $user->getRules();
		$rules = array(
			'current_password'		=> 'required',
			'password'				=> $user_rules['password'],
			'password_confirmation'	=> 'required',
		);

		$input = Input::only(array_keys($rules));
		$input['username'] = $user->username;

		$validator = Validator::make($input, $rules)->setAttributeNames([
			'username' => $user->getLabel('username'), //used in case username and password match
			'current_password'	=> _('Current password'),
			'password'	=> _('New password'),
			'password_confirmation' => _('Repeat password'),
		]);

		// Validate form
		if($validator->fails())
			return Redirect::back()->withInput($input)->withErrors($validator);

		// Check old credentials
		if( ! Auth::validate(['username' => $user->username, 'password' => $input['current_password']]))
		{
			$validator->messages()->add('current_password', _('Wrong password'));
			return Redirect::back()->withInput($input)->withErrors($validator);
		}

		// Update password
		$user->password = $input['password'];
		if( ! $user->removeRule('password', 'confirmed')->save())
			return Redirect::back()->withInput($input)->withErrors($user->getErrors());

		return Redirect::back()->withSuccess(_('Password updated'));
	}

	/**
	 * Show form for changing current user regional settings.
	 *
	 * @return Response
	 */
	public function showRegionalForm()
	{
		$this->layout->title = _('User panel');
		$this->layout->subtitle = _('Locale');
		$this->layout->content = View::make('userpanel.regional')->withUser(Auth::user());
	}

	/**
	 * Change current user regional settings.
	 *
	 * @return Response
	 */
	public function updateRegional()
	{
		$user = Auth::user();
		$user->country_id = Input::get('country_id');
		$user->language_id = Input::get('language_id');

		if($user->removeRule('password', 'required|confirmed')->save())
			return Redirect::back()->withSuccess(_('Locale options have been saved'));

		return Redirect::back()->withInput()->withErrors($user->getErrors());
	}
}
