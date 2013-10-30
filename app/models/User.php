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
	 * @param  mixed $permissions
	 * @return bool
	 */
	public function hasPermission($permissions)
	{
		//Unsaved users have no permissions
		if( ! $this->id)
			return false;

		//Store profile permissions in cache to save some queries
		$profile_permissions = Cache::remember("profile{$this->profile_id}permissions", 60, function() {
			return $this->profile->permissions->lists('id');
		});

		$permissions = is_array($permissions) ? $permissions : func_get_args();

		return (0 == count(array_diff($permissions, $profile_permissions)));
	}

	/**
	 * Check if user's profile has ANY of the required permissions
	 *
	 *
	 * @param  mixed $permissions
	 * @return bool
	 */
	public function hasAnyPermission($permissions)
	{
		//Unsaved users have no permissions
		if( ! $this->id)
			return false;

		//Store profile permissions in cache to save some queries
		$profile_permissions = Cache::remember("profile{$this->profile_id}permissions", 60, function() {
			return $this->profile->permissions->lists('id');
		});

		$permissions = is_array($permissions) ? $permissions : func_get_args();

		foreach($profile_permissions as $p)
		{
			if(in_array($p, $permissions))
				return true;
		}

		return false;
	}
}
