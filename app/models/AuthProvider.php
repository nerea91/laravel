<?php

class AuthProvider extends Eloquent {

	protected $softDelete = true;

	public static $rules = array(
		'name' => 'required|alpha_num|max:32|unique',
		'title' => 'required|max:32|unique',
		'logins_count' => 'integer|min:0',
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
