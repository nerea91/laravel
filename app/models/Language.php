<?php

class Language extends Way\Database\Model {

	protected $softDelete = true;

	public $timestamps = false;
	public static $rules = array(
		'code' => 'required|alpha|size:2',
		'name' => 'required|max:32',
		'english_name' => 'required|max:32',
		'locale' => 'required|size:5',
		'default' => 'required|integer|min:0|max:1',
		'priority' => 'required|integer'
	);
}
