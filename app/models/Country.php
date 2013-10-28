<?php

class Country extends Stolz\Database\Model {

	protected $softDelete = true;
	protected $guarded = array();
	public $timestamps = false;

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|max:64|unique'],
			'full_name' => [_('Full name'), 'max:128|unique'],
			'iso_3166_2' => [_('ISO 3166 (2 digits)'), array('required', 'size:2', 'regex:/[A-Z]+/', 'unique')],
			'iso_3166_3' => [_('ISO 3166 (3 digits)'), array('required', 'size:3', 'regex:/[A-Z]+/', 'unique')],
			'country_code' => [_('Country code'), array('required', 'size:3', 'regex:/[0-9]+/','unique')],
			'capital' => [_('Capital'), 'max:64'],
			'citizenship' => [_('Citizenship'), 'max:64'],
			'currency' => [_('Currency'), 'max:64'],
			'currency_code' => [_('Currency code'), array('regex:/[A-Z]+/', 'max:16')],
			'currency_sub_unit' => [_('Currency sub unit'), 'max:32'],
			'region_code' => [_('Region code'), array('size:3', 'regex:/[0-9]+/')],
			'sub_region_code' => [_('Subregion code'), array('size:3', 'regex:/[0-9]+/')],
			'eea' => [_('European Economic Area'), 'required|integer|min:0|max:1'],
		));
	}

	// Relationships ==========================================================

	public function users()
	{
		return $this->hasMany('User');
	}

	// Logic ==================================================================
}
