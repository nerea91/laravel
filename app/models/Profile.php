<?php

class Profile extends Eloquent {

	public static $rules = array(
		'name' => 'required|max:64',
		'description' => 'max:255',
	);

	// Relationships ==========================================================

	public function users()
	{
		return $this->hasMany('User');
	}

	// Events ==================================================================

	public static function boot()
	{
		parent::boot();

		static::deleting(function($model)
		{
			//Prevent deleting Superuser profiler
			if($model->id == 1)
				return false;
		});
	}

	// Logic ==================================================================
}
