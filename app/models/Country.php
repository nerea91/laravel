<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Country extends BaseModel
{
	use SoftDeletingTrait;
	public $timestamps = false;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');

	// Meta ========================================================================

	/**
	 * Singular form of this model's name
	 *
	 * @return string
	 */
	public function singular()
	{
		return _('Country');
	}

	/**
	 * Plural form of this model's name
	 *
	 * @return string
	 */
	public function plural()
	{
		return _('Countries');
	}

	/**
	 * What should be returned when this model is casted to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}

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

	/**
	 * Search this model
	 *
	 * @param  string $query
	 * @return Illuminate\Database\Eloquent\Collection (of Currency)
	 */
	public static function search($query)
	{
		if(is_numeric($query))
			$search = self::where('code', $query);
		else
		{
			$search = self::where('name', 'LIKE', "%$query%")->orWhere('full_name', 'LIKE', "%$query%");
			if(strlen($query) == 2)
				$search->orWhere('iso_3166_2', $query);
			if(strlen($query) == 3)
				$search->orWhere('iso_3166_3', $query);
		}

		return $search->orderBy('name')->get();
	}

	// Logic =======================================================================
}
