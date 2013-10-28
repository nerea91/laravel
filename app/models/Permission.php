<?php

class Permission extends Stolz\Database\Model {

	public $timestamps = false;

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|max:64'],
			'description' => [_('Description'), 'max:255'],
			'type_id' => [_('Type'), 'required|exists:permissiontypes'],
		));
	}

	// Relationships ==========================================================

	public function type()
	{
		return $this->belongsTo('PermissionType', 'type_id');
	}

	public function profiles()
	{
		return $this->belongsToMany('Profile')->withTimestamps();
	}

	// Logic ==================================================================
}
