<?php

class Permission extends BaseModel
{
	public $timestamps = false;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');

	// Meta ========================================================================

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|max:64'],
			'description' => [_('Description'), 'max:255'],
			'type_id' => [_('Type'), 'required|exists:permissiontypes,id'],
		));
	}

	// Relationships ===============================================================

	public function profiles()
	{
		return $this->belongsToMany('Profile');
	}

	public function type()
	{
		return $this->belongsTo('PermissionType', 'type_id');
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Get ALL permissions grouped by type.
	 *
	 * @return array
	 */
	public static function getGroupedByType()
	{
		$permissions = array();
		foreach(self::orderBy('name')->remember(60 * 24, 'allPermissionsGroupedByType')->get() as $p)
			$permissions[$p->type_id][$p->id] = $p->name;
		return $permissions;
	}

	// Logic =======================================================================
}
