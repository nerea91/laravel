<?php

class Account extends Eloquent {

	protected $hidden = array('access_token');

	public static $rules = array(
		'uid' => 'required|max:128',
		'access_token' => 'required',
		'nickname' => 'max:128',
		'email' => 'email|max:255',
		'name' => 'max:128',
		'first_name' => 'max:64',
		'last_name' => 'max:64',
		'image' => 'max:255',
		'locale' => 'max:5',
		'location' => 'max:128',

		'provider_id' => 'required|exists:authproviders',
		'user_id' => 'required|exists:users',
	);

	// Relationships ==========================================================

	public function provider()
	{
		return $this->belongsTo('AuthProvider', 'provider_id');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	// Events ==================================================================

	public static function boot()
	{
		parent::boot();

		static::deleting(function($model)
		{
			//Prevent deleting Superuser admin account
			if($model->id == 1)
				return false;
		});
	}

	// Logic ==================================================================
}
