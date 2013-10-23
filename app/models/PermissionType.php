<?php

class PermissionType extends Way\Database\Model {

	public $timestamps = false;
	public static $rules = array(
		'name' => 'required|max:64',
		'description' => 'max:255'
	);

	// Relationships ==========================================================

	public function permissions()
	{
		return $this->hasMany('Permission');
	}

	// Logic ==================================================================
}
