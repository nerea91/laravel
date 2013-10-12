<?php

use Illuminate\Auth\UserInterface;

class User extends Model implements UserInterface {

	protected $softDelete = true;

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
		//to-do fetch from accounts tables return $this->email;
	}

	// Logic ==================================================================

}
