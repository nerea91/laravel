<?php

class Permission extends Way\Database\Model {

	public $timestamps = false;
	public static $rules = array(
		'name' => 'required|max:64',
		'description' => 'max:255',
		'type_id' => 'required|exists:permissiontypes'
	);

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
