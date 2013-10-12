<?php

class PermissionType extends Model {

	public $timestamps = false;
	public static $rules = array(
		'name' => 'required|max:64',
		'description' => 'max:255'
	);
}
