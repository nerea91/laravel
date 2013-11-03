<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Stolz\Database\Model implements UserInterface, RemindableInterface {

	protected $softDelete = true;
	protected $guarded = array('password', 'password_confirmation');
	protected $hidden = array('password', 'password_confirmation');

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'username' => [_('Username'), 'required|min:4|max:32|regex:/^[a-zA-z]+[a-zA-z0-9]+$/|unique'],
			'name' => [_('Name'), 'max:64'],
			'description' => [_('Description'), 'max:128'],
			'password' => [_('Password'), 'required|min:5|max:64|confirmed'],
			'country_id' => [_('Country'), 'exists:countries,id'],
			'profile_id' => [_('Profile'), 'required|exists:profiles,id'],
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
			// Prevent deleting Admin user
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
		// to-do fetch email from accounts table
	}

	// Logic ==================================================================

	/**
	 * Check if user's profile has ALL of the provided permissions
	 *
	 * @param dynamic $permissions
	 * @return bool
	 */
	public function hasPermission($permissions)
	{
		// Unsaved users have no permissions
		if( ! $this->id)
			return false;

		$permissions = is_array($permissions) ? $permissions : func_get_args();

		return $this->profile->hasPermission($permissions);
	}

	/**
	 * Check if user's profile has ANY of the provided permissions
	 *
	 * @param dynamic $permissions
	 * @return bool
	 */
	public function hasAnyPermission($permissions)
	{
		// Unsaved users have no permissions
		if( ! $this->id)
			return false;

		$permissions = is_array($permissions) ? $permissions : func_get_args();

		return $this->profile->hasAnyPermission($permissions);
	}
}
