<?php namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
	use SoftDeletes;
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
		return (string) $this->name;
	}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|alpha_space|max:64|unique'],
			'full_name' => [_('Full name'), 'nullable|max:128|unique'],
			'iso_3166_2' => [_('2 letters code'), 'required|size:2|regex:/^[A-Z]+$/|unique'],
			'iso_3166_3' => [_('3 letters code'), 'required|size:3|regex:/^[A-Z]+$/|unique'],
			'code' => [_('Numeric code'), 'required|size:3|regex:/^[0-9]+$/|unique'],
			'capital' => [_('Capital'), 'nullable|max:64'],
			'citizenship' => [_('Citizenship'), 'nullable|max:64'],
			'region' => [_('Region code'), 'nullable|size:3|regex:/^[0-9]+$/'],
			'subregion' => [_('Subregion code'), 'nullable|size:3|regex:/^[0-9]+$/'],
			'eea' => [_('European Economic Area'), 'required|integer|min:0|max:1'],
			'currency_id' => [_('Currency'), 'nullable|exists:currencies,id'],
		));
	}

	// Relationships ===============================================================

	public function accounts()
	{
		return $this->hasManyThrough('App\Account', 'App\User');
	}

	public function currency()
	{
		return $this->belongsTo('App\Currency')->withTrashed();
	}

	public function users()
	{
		return $this->hasMany('App\User');
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Search this model
	 *
	 * @param  string $pattern
	 * @return \Illuminate\Database\Eloquent\Collection (of Currency)
	 */
	public static function search($pattern)
	{
		// Apply parameter grouping http://laravel.com/docs/queries#advanced-wheres
		return self::where(function($query) use ($pattern) {

			// If pattern is a number search in the numeric columns
			if(is_numeric($pattern))
				$query->orWhere('id', $pattern);

			// If it looks like an ISO code
			if(strlen($pattern) === 2)
				$query->orWhere('iso_3166_2', $pattern);
			if(strlen($pattern) === 3)
				$query->orWhere('iso_3166_3', $pattern);

			// In any other case search in all the relevant columns
			$query->orWhere('name', 'LIKE', "%$pattern%")->orWhere('full_name', 'LIKE', "%$pattern%");

		})->orderBy('name')->get();
	}

	// Logic =======================================================================
}
