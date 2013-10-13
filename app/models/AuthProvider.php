<?php

class AuthProvider extends Eloquent {

	protected $softDelete = true;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('oauth2_secret');

	public static $rules = array(
		'name' => 'required|alpha_num|max:32|unique',
		'title' => 'required|max:32|unique',
		'logins_count' => 'integer|min:0',
		'oauth2_id' => 'max:255',
		'oauth2_secret' => 'max:255',
	);

	// Relationships ==========================================================

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
			//Prevent deleting Laravel Auth Provider
			if($model->id == 1)
				return false;
		});
	}

	// Logic ==================================================================
}
