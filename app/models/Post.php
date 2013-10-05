<?php

class Post extends Way\Database\Model {

	protected $softDelete = true;

	public static $rules = array(
		'title' => 'required',
		'body' => 'required'
	);

	//Relationships
	public function tags()
	{
		return $this->belongsToMany('Tag'); //Semanticamente no es mas correcto decir hasMany?
	}

	public function user()
	{
		return $this->belongsTo('User');
	}
}
