<?php

class Post extends Model {

	protected $softDelete = true;
	protected $guarded = array();

	public static $rules = array(
		'title' => 'required',
		'body' => 'required'
	);

	// Relationships ==========================================================

	public function tags()
	{
		return $this->belongsToMany('Tag'); //Semanticamente no es mas correcto decir hasMany?
	}

	public function user()
	{
		return $this->belongsTo('User');
	}
}
