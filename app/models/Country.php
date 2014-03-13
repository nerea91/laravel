<?php

class Country extends BaseModel {

	public $timestamps = false;
	protected $softDelete = true;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');

	// Meta ========================================================================

	public function singular() { return _('Country');}	// Singular form of this model's name
	public function plural() { return _('Countries');}	// Singular name of this model's name
	public function __toString() { return $this->name;}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|alpha_space|max:64|unique'],
			'full_name' => [_('Full name'), 'max:128|unique'],
			'iso_3166_2' => [_('2 letters code'), 'required|size:2|regex:/^[A-Z]+$/|unique'],
			'iso_3166_3' => [_('3 letters code'), 'required|size:3|regex:/^[A-Z]+$/|unique'],
			'code' => [_('Numeric code'), 'required|size:3|regex:/^[0-9]+$/|unique'],
			'capital' => [_('Capital'), 'max:64'],
			'citizenship' => [_('Citizenship'), 'max:64'],
			'region' => [_('Region code'), 'size:3|regex:/^[0-9]+$/'],
			'subregion' => [_('Subregion code'), 'size:3|regex:/^[0-9]+$/'],
			'eea' => [_('European Economic Area'), 'required|integer|min:0|max:1'],
			'currency_id' => [_('Currency'), 'exists:currencies,id'],
		));
	}

	// Relationships ===============================================================

	public function currency()
	{
		return $this->belongsTo('Currency');
	}

	public function users()
	{
		return $this->hasMany('User');
	}
	
	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	// Logic =======================================================================

	/**
	 * Search this model
	 *
	 * @param  string $query
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function search($query)
	{
		if(is_numeric($query))
			$search = Self::where('code', $query);
		else
		{
			$search = Self::where('name', 'LIKE', "%$query%")->orWhere('full_name', 'LIKE', "%$query%");
			if(strlen($query) == 2)
				$search->orWhere('iso_3166_2', $query);
			if(strlen($query) == 3)
				$search->orWhere('iso_3166_3', $query);
		}

		return $search->orderBy('name')->get();
	}
}
