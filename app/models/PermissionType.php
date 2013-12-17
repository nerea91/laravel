<?php

class PermissionType extends BaseModel {

	public $table = 'permissiontypes';
	public $timestamps = false;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');

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
		return $this->hasMany('Permission', 'type_id');
	}

	// Logic ==================================================================

	/**
	 * Get types with at least one permission
	 */
	public function scopeGetUsed($query)
	{
		return $query->has('permissions')->orderBy('name')->remember(60*24)->get();
	}

}
