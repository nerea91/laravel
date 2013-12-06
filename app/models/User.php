<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Stolz\Database\Model implements UserInterface, RemindableInterface {

	protected $softDelete = true;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('password', 'password_confirmation', 'current_password');

	// Meta ===================================================================

	public function singular() { return _('User');}	// Singular form of this model's name
	public function plural() { return _('Users');}	// Singular name of this model's name
	public function __toString() { return $this->username;}

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'username' => [_('Username'), 'required|min:4|max:32|regex:/^[a-zA-z]+[a-zA-z0-9]+$/|unique'],
			'name' => [_('Name'), 'alpha_dash_space|max:64'],
			'description' => [_('Description'), 'max:128'],
			'password' => [_('Password'), 'required|min:5|max:60|different:username|confirmed'],
			'country_id' => [_('Country'), 'exists:countries,id'],
			'language_id' => [_('Language'), 'exists:languages,id'],
			'profile_id' => [_('Profile'), 'required|exists:profiles,id'],
		));
	}

	// Relationships ==========================================================

	public function country()
	{
		return $this->belongsTo('Country');
	}

	public function language()
	{
		return $this->belongsTo('Language');
	}

	public function profile()
	{
		return $this->belongsTo('Profile');
	}

	public function accounts()
	{
		return $this->hasMany('Account');
	}

	// Events ==================================================================

	public static function boot()
	{
		parent::boot();

		// BUG To hash the password instead of 2 calls to creating and updating it should be only 1 call to the
		// saving event but it doesn't work http://forums.laravel.io/viewtopic.php?id=15463
		static::creating(function($model)
		{
			// Hash password if not hashed
			if (Hash::needsRehash($model->password))
				$model->password = Hash::make($model->password);
		});
		static::updating(function($model)
		{
			// Hash password if not hashed
			if (Hash::needsRehash($model->password))
				$model->password = Hash::make($model->password);
		});

		static::deleting(function($model)
		{
			// Prevent deleting Admin user
			if($model->id == 1)
				return false;
		});
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

		$permissions = (is_array($permissions)) ? $permissions : func_get_args();

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

		$permissions = (is_array($permissions)) ? $permissions : func_get_args();

		return $this->profile->hasAnyPermission($permissions);
	}

	/**
	 * If user name is not null return it. Otherwise return username
	 *
	 * @return string
	 */
	public function name()
	{
		if(is_null($this->name))
			return $this->username;

		return $this->name;
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
}
