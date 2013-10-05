<?php

class Tag extends Way\Database\Model {

	protected timestamps = false;

	public static $rules = array(
		'name' => 'required|unique:tags'
	);

	//Relationships
	public function posts()
	{
		return $this->belongsToMany('Post');
	}
}
