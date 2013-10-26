<?php

class PermissionType extends Stolz\Model {

	public $table = 'permissiontypes';
	public $timestamps = false;

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
		return $this->hasMany('Permission');
	}

	// Logic ==================================================================
}
