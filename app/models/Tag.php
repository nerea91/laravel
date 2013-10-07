<?php

class Tag extends Model {

	protected $guarded = array();

	public $timestamps = false;
	public static $rules = array(
		'name' => 'required|unique'
	);

	// Relationships ==========================================================

	public function posts()
	{
		return $this->belongsToMany('Post');
	}
}
