<?php

class Profile extends Way\Database\Model {

	protected $guarded = array('id', 'created_at', 'updated_at');

	public static $rules = array(
		'name' => 'required|max:64|unique',
		'description' => 'max:255',
	);

	// Relationships ==========================================================

	public function permissions()
	{
		return $this->belongsToMany('Permission')->withTimestamps();
	}

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
