<?php

use Illuminate\Auth\UserInterface;

class User extends Model implements UserInterface {

	protected $softDelete = true;

	public static $rules = array(
		'name' => 'required|unique',
		'email' => 'email|unique',
		'age' => 'integer'
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

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}
