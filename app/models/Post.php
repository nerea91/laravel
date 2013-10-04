<?php

class Post extends Eloquent {

	protected $softDelete = true;

	public static $rules = array(
		'title' => 'required',
		'body' => 'required'
	);
}
