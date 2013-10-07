<?php

class Phone extends Model {

	protected $guarded = array();

	public static $rules = array(
		'number' => 'required|integer|unique',
		'imei' => 'required|integer|unique'
	);

	// Relationships ==========================================================

	public function user()
	{
		return $this->belongsTo('User');
	}
}
