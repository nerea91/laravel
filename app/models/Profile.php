<?php

class Profile extends Stolz\Database\Model {

	protected $guarded = array();

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|max:64|unique'],
			'description' => [_('Description'), 'max:255'],
		));
	}

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

		static::updated(function($model)
		{
			//Purge permissions cache
			Cache::forget("profile{$this->id}permissions");
		});

	}

	// Logic ==================================================================
}
