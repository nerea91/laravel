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
			Cache::forget("profile{$model->id}permissions");
		});

		static::deleted(function($model)
		{
			//Purge permissions cache
			Cache::forget("profile{$model->id}permissions");
		});

	}

	// Logic ==================================================================

	/**
	 * Get profile permissions
	 *
	 * @return array
	 */
	public function getPermissions()
	{
		//Unsaved profiles have no permissions
		if( ! $this->id)
			return array();

		//Store profile permissions in cache to save some queries
		$permissions = Cache::remember("profile{$this->id}permissions", 60, function() {
			return $this->permissions->lists('id');
		});

		return $permissions;
	}

	/**
	 * Check if profile has ALL of the provided permissions
	 *
	 * @param dynamic $permissions
	 * @return bool
	 */
	public function hasPermission($permissions)
	{
		//Unsaved profiles have no permissions
		if( ! $this->id)
			return false;

		$permissions = is_array($permissions) ? $permissions : func_get_args();

		return (0 == count(array_diff($permissions, $this->getPermissions())));
	}

	/**
	 * Check if profile has ANY of the provided permissions
	 *
	 * @param dynamic $permissions
	 * @return bool
	 */
	public function hasAnyPermission($permissions)
	{
		//Unsaved profiles have no permissions
		if( ! $this->id)
			return false;

		$permissions = is_array($permissions) ? $permissions : func_get_args();

		foreach($this->getPermissions() as $p)
		{
			if(in_array($p, $permissions))
				return true;
		}

		return false;
	}
}
