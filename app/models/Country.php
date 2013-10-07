<?php

class Country extends Way\Database\Model {

	protected $softDelete = true;


	public $timestamps = false;
	public static $rules = array(
		'name' => 'required|max:64|unique:countries',
		'full_name' => 'max:128',
		'iso_3166_2' => array('required', 'size:2', 'regex:[A-Z]+', 'unique:countries'),
		'iso_3166_3' => array('required', 'size:3', 'regex:[A-Z]+', 'unique:countries'),
		'country_code' => array('required', 'size:3', 'regex:[0-9]+','unique:countries'),
		'capital' => 'max:64',
		'citizenship' => 'max:64',
		'currency' => 'max:64',
		'currency_code' => array('regex:[A-Z \(\)]+', 'max:16'),
		'currency_sub_unit' => 'max:32',
		'region_code' => array('size:3', 'regex:[0-9]+'),
		'sub_region_code' => array('size:3', 'regex:[0-9]+'),
		'eea' => 'required|integer|min:0|max:1'
	);

	// Relationships ==========================================================
	
	public function users()
	{
		return $this->hasMany('User');
	}
}
