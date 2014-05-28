<?php

class PermissionType extends BaseModel
{

	public $table = 'permissiontypes';
	public $timestamps = false;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');

	// Meta ========================================================================

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
		return $this->hasMany('Permission', 'type_id');
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	// Logic =======================================================================

	/**
	 * Get types with at least one permission
	 *
	 * @param Illuminate\Database\Eloquent\Builder
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function scopeGetUsed($query)
	{
		return $query->has('permissions')->orderBy('name')->remember(60*24, 'usedPermissionTypes')->get();
	}
}
