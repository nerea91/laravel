<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Stolz\Database\Model implements UserInterface, RemindableInterface {

	protected $softDelete = true;
	protected $guarded = array('password');
	protected $hidden = array('password');

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'username' => [_('Username'), 'required|max:64|alpha_num|regex:/^[a-zA-z]/|unique'],
			'name' => [_('Name'), 'email|max:64'],
			'password' => [_('Password'), 'required|min:5'],
			'country_id' => [_('Country'), 'exists:countries'],
			'profile_id' => [_('Profile'), 'required|exists:profiles'],
		));
	}

	// Relationships ==========================================================

	public function profile()
	{
		return $this->belongsTo('Profile');
	}

	public function country()
	{
		return $this->belongsTo('Country');
	}

	public function accounts()
	{
		return $this->hasMany('Account');
	}

	// Events ==================================================================

	public static function boot()
	{
		parent::boot();

		static::deleting(function($model)
		{
			//Prevent deleting Admin user
			if($model->id == 1)
				return false;
		});
	}

	// UserInterface implementation for auth ==================================

	/**
	* Get the unique identifier for the user.
	*
	* @return mixed
	*/
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	* Get the password for the user.
	*
	* @return string
	*/
	public function getAuthPassword()
	{
		return $this->password;
	}

	// RemindableInterface implementation for auth ============================

	/**
	* Get the e-mail address where password reminders are sent.
	*
	* @return string
	*/
	public function getReminderEmail()
	{
		//to-do fetch email from accounts table
	}

	// Logic ==================================================================

	/**
	 * Check if user's profile has ALL of the provided permissions
	 *
	 * @param dynamic
	 * @return bool
	 */
	public function hasPermission()
	{
		//Unsaved users have no permissions
		if( ! $this->id)
			return false;

		return $this->profile->hasPermission(func_get_args());
	}

	/**
	 * Check if user's profile has ANY of the provided permissions
	 *
	 * @param dynamic
	 * @return bool
	 */
	public function hasAnyPermission()
	{
		//Unsaved users have no permissions
		if( ! $this->id)
			return false;

		return $this->profile->hasAnyPermission(func_get_args());
	}
}
