<?php

class Profile extends BaseModel {

	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');

	// Meta ========================================================================

	/**
	 * Singular form of this model's name
	 *
	 * @return string
	 */
	public function singular()
	{
		return _('Profile');
	}

	/**
	 * Plural form of this model's name
	 *
	 * @return string
	 */
	public function plural()
	{
		return _('Profiles');
	}

	/**
	 * What should be returned when this model is casted to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|max:64|unique'],
			'description' => [_('Description'), 'max:255'],
		));
	}

	// Relationships ===============================================================

	public function permissions()
	{
		return $this->belongsToMany('Permission')->withTimestamps();
	}

	public function users()
	{
		return $this->hasMany('User');
	}

	// Events ======================================================================

	public static function boot()
	{
		// NOTE saving   -> creating -> created   -> saved
		// NOTE saving   -> updating -> updated   -> saved
		// NOTE deleting -> deleted  -> restoring -> restored

		parent::boot();

		static::saved(function ($profile) {
			// Purge permissions cache
			Cache::forget("profile{$profile->id}permissions");
		});

		static::deleted(function ($profile) {
			// Purge permissions cache
			Cache::forget("profile{$profile->id}permissions");
		});

	}

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Search this model
	 *
	 * @param  string $query
	 * @return Illuminate\Database\Eloquent\Collection (of Profile)
	 */
	public static function search($query)
	{
		return self::where('name', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%")->orderBy('name')->get();
	}

	/**
	 * Determine if already exists a profile which has exactly
	 * the provided permissions.
	 *
	 * If no profiles are found returns bolean FALSE, otherwise
	 * returns the profile name.
	 *
	 * @param  array   $permissions
	 * @param  integer $excluded_id
	 * @return mixed   boolean|string
	 */
	public static function existSimilar($permissions, $excluded_id = null)
	{
		$profiles = (is_null($excluded_id)) ? Profile::all() : Profile::where('id', '<>', $excluded_id)->get();
		$permissions = array_map('intval', $permissions);
		sort($permissions);

		foreach($profiles as $p)
		{
			$profile_permissions = $p->getPermissions();
			sort($profile_permissions);

			if($permissions == $profile_permissions)
				return $p->name;
		}

		return false;
	}

	// Logic =======================================================================

	/**
	 * Determine whether or not the model can be deleted.
	 *
	 * @param  boolean $throwExceptions
	 * @return boolean
	 *
	 * @throws ModelDeletionException
	 */
	public function deletable($throwExceptions = false)
	{
		// Prevent deleting Superuser profile
		if($this->id == 1)
		{
			if($throwExceptions)
				throw new ModelDeletionException(sprintf(_('Deleting %s is not allowed'), $this));
			return false;
		}

		return true;
	}

	/**
	 * Get profile permissions
	 *
	 * @return array
	 */
	public function getPermissions()
	{
		// Unsaved profiles have no permissions
		if( ! $this->id)
			return array();

		// Store profile permissions in cache to save some queries
		$permissions = Cache::remember("profile{$this->id}permissions", 60, function () {
			return $this->permissions->lists('id');
		});

		return $permissions;
	}

	/**
	 * Get profile permissions grouped by type.
	 *
	 * @param  boolean $use_type_name_for_keys
	 * @return array
	 */
	public function getPermissionsGroupedByType($use_type_name_for_keys = false)
	{
		// Unsaved profiles have no permissions
		if( ! $this->id)
			return array();

		$permissions = array();
		foreach($this->permissions()->with('type')->orderBy('name')->get() as $p)
			$permissions[($use_type_name_for_keys) ? $p->type->name : $p->type_id][$p->id] = $p->name;

		ksort($permissions);
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
		// Unsaved profiles have no permissions
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
		// Unsaved profiles have no permissions
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

	/**
	 * Get usernames of users using this profile
	 *
	 * @return array
	 */
	public function getUsernamesArray()
	{
		return $this->users()->orderBy('username')->lists('username');
	}

	/**
	 * Get all profiles whose permissions are same as (or a subset of) $this profile permissions.
	 *
	 * @return Illuminate\Database\Eloquent\Collection (of Profile)
	 * @throws Exception
	 */
	public function getSimilarOrInferior()
	{
		// Unsaved profiles have no permissions therefore cannot be compared
		if( ! $this->id)
			throw new Exception(_('Unsaved profiles cannot be compared'));

		// Profiles with more permissions than current one
		$excludedProfiles = DB::table('permission_profile')
		->select(DB::raw('profile_id, COUNT(permission_id) AS permission_count'))
		->whereRaw('permission_id NOT IN (SELECT DISTINCT(permission_id) FROM permission_profile WHERE profile_id=?)', [$this->id])
		->groupBy('profile_id')
		->having('permission_count', '>', 0)
		->get();

		// Invert condition
		return ($excludedProfiles) ? self::whereNotIn('id', array_fetch($excludedProfiles, 'profile_id'))->get() : self::all();
	}

}
