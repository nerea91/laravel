<?php

class Permission extends Eloquent {

	public $timestamps = false;
	public static $rules = array(
		'name' => 'required|max:64',
		'description' => 'max:255',
		'type_id' => 'exists:permissiontypes'
	);

	// Relationships ==========================================================

	public function type()
	{
		return $this->belongsTo('PermissionType');
	}

	// Logic ==================================================================
}
