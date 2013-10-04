<?php

class Country extends Eloquent {

	protected $softDelete = true;
	public $timestamps = false;

	public static $rules = array(
		'name' => 'required|max:64|unique:countries',
		'full_name' => 'max:128',
		'iso_3166_2' => 'required|size:2|unique:countries',
		'iso_3166_3' => 'required|size:3|unique:countries',
		'country_code' => 'required|size:3|unique:countries',
		'capital' => 'max:64',
		'citizenship' => 'max:64',
		'currency' => 'max:64',
		'currency_code' => 'max:16',
		'currency_sub_unit' => 'max:32',
		'region_code' => 'size:3',
		'sub_region_code' => 'size:3',
		'eea' => 'required'
	);
}
