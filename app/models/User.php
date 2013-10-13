<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Model implements UserInterface, RemindableInterface {

	protected $softDelete = true;
	protected $guarded = array('id', 'password', 'permissions_cache', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('password', 'permissions_cache');

	public static $rules = array(
		'username' => 'required|max:64|alpha_num|regex:/^[a-zA-z]/|unique',
		'name' => 'email|max:64',
		'password' => 'required|min[5]',
		'country_id' => 'exists:countries',
		'profile_id' => 'required|exists:profiles',
	);

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
	 * Checks if user's profile has ALL of the required permissions
	 *
	 * To save extra databases queries from subsequent calls
	 * it stores profile permissions in chache
	 *
	 * @param  mixed $required_permissions
	 * @return  bool
	 */
	public function hasPermission($required_permissions)
	{
		$required_permissions = is_array($required_permissions) ? $required_permissions : func_get_args();

		if( ! isset($this->permissions_cache))
			$this->permissions_cache = $this->profile->permissions->lists('id');

		return (0 == count(array_diff($required_permissions, $this->permissions_cache)));
	}

	/**
	 * Checks if user's profile has ANY of the required permissions
	 *
	 * To save extra databases queries from subsequent calls
	 * it stores profile permissions in chache
	 *
	 * @param  mixed $required_permissions
	 * @return  bool
	 */
	public function hasAnyPermission($required_permissions)
	{
		$required_permissions = is_array($required_permissions) ? $required_permissions : func_get_args();

		if( ! isset($this->permissions_cache))
			$this->permissions_cache = $this->profile->permissions->lists('id');

		foreach($this->permissions_cache as $p)
		{
			if(in_array($p, $required_permissions))
				return true;
		}
		return false;
	}
}
