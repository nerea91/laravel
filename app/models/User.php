<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Way\Database\Model implements UserInterface, RemindableInterface {

	protected $softDelete = true;
	protected $hidden = array('password', 'deleted_at');
	protected $guarded = array('salt', 'password', 'deleted_at');

	public static $rules = array(
		'name' => 'required|unique:users',
		'email' => 'email|unique:users',
		'age' => 'integer'
	);

	//Relationships
	public function posts()
	{
		return $this->hasMany('Post');
	}

	public function phone()
	{
		return $this->hasOne('Phone');
	}

	public function country()
	{
		return $this->hasOne('Country');
	}


	/* ==== UserInterface implementation for auth */

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
