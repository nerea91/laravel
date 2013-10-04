<?php

class User extends Eloquent {

	protected $softDelete = true;

	public static $rules = array(
		'name' => 'required:unique',
		'email' => 'email',
		'age' => 'integer'
	);
}
