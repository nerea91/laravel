<?php

class Phone extends Way\Database\Model {

	protected $guarded = array();

	public static $rules = array(
		'number' => 'required|integer|unique:phones',
		'imei' => 'required|integer|unique:phones'
	);

	// Relationships ==========================================================
	
	public function user()
	{
		return $this->belongsTo('User');
	}
}
