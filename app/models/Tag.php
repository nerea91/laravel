<?php

class Tag extends Eloquent {

	protected $softDelete = true;

	public static $rules = array(
		'name' => 'required'
	);
}
