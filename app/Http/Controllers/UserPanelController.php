<?php namespace App\Http\Controllers;

use Auth;
use Input;
use Validator;
use View;

class UserPanelController extends Controller
{
	protected $layout = 'layouts.admin';
	protected $user;

	/**
	 * Class constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Enable CSRF filter
		parent::__construct();

		View::share('user', $this->user = Auth::user());
	}

	/**
	 * Show form for changing current user options.
	 *
	 * @return Response
	 */
	public function showOptionsForm()
	{
		$this->layout->title = _('User panel');
		$this->layout->subtitle = _('Options');
		$this->layout->content = view('userpanel.options')->withOptions($this->user->getAssignableOptions());
	}

	/**
	 * Change current user options.
	 *
	 * @return Response
	 */
	public function updateOptions()
	{
		$errors = $this->user->setOptions(Input::all());

		if($errors->any())
			return redirect()->back()->withInput()->withErrors($errors);

		return redirect()->back()->withSuccess(_('Options have been saved'));
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
		$this->layout->content = view('userpanel.password');
	}

	/**
	 * Change current user password.
	 *
	 * @return Response
	 */
	public function updatePassword()
	{
		$userRules = $this->user->getRules();
		$rules = array(
			'current_password'		=> 'required',
			'password'				=> $userRules['password'],
			'password_confirmation'	=> 'required',
		);

		$input = Input::only(array_keys($rules));
		$input['username'] = $this->user->username;

		$validator = Validator::make($input, $rules)->setAttributeNames([
			'username' => $this->user->getLabel('username'), //used in case username and password match
			'current_password'	=> _('Current password'),
			'password'	=> _('New password'),
			'password_confirmation' => _('Repeat password'),
		]);

		// Validate form
		if($validator->fails())
			return redirect()->back()->withInput($input)->withErrors($validator);

		// Check old credentials
		if( ! Auth::validate(['username' => $this->user->username, 'password' => $input['current_password']]))
		{
			$validator->messages()->add('current_password', _('Wrong password'));
			return redirect()->back()->withInput($input)->withErrors($validator);
		}

		// Update password
		$this->user->password = $input['password'];
		if( ! $this->user->removeRule('password', 'confirmed')->save())
			return redirect()->back()->withInput($input)->withErrors($this->user->getErrors());

		return redirect()->back()->withSuccess(_('Password updated'));
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
		$this->layout->content = view('userpanel.regional');
	}

	/**
	 * Change current user regional settings.
	 *
	 * @return Response
	 */
	public function updateRegional()
	{
		$this->user->country_id = Input::get('country_id');
		$this->user->language_id = Input::get('language_id');

		if($this->user->removeRule('password', 'required|confirmed')->save())
			return redirect()->back()->withSuccess(_('Locale options have been saved'));

		return redirect()->back()->withInput()->withErrors($this->user->getErrors());
	}
}