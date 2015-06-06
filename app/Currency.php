<?php namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
	use SoftDeletes;
	public $timestamps = false;
	protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

	// Meta ========================================================================

	/**
	 * Singular form of this model's name
	 *
	 * @return string
	 */
	public function singular()
	{
		return _('Currency');
	}

	/**
	 * Plural form of this model's name
	 *
	 * @return string
	 */
	public function plural()
	{
		return _('Currencies');
	}

	/**
	 * What should be returned when this model is casted to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->code;
	}

	// Validation ==================================================================

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setRules([
			'code'                => [_('Code'), 'required|size:3|regex:/^[A-Z]+$/|unique'], // ISO 4217
			'name'                => [_('Name'), 'required|max:64'],
			'name2'               => [_('Alt. name'), 'max:64'],
			'symbol'              => [_('Symbol'), 'max:8'],
			'symbol2'             => [_('Alt. symbol'), 'max:8'],
			'symbol_position'     => [_('Symbol position'), 'required|integer'],
			'decimal_separator'   => [_('Decimal separator'), 'required|size:1'],
			'thousands_separator' => [_('Thousands separator'), 'size:1'],
			'subunit'             => [_('Subunit'), 'max:16'],
			'subunit2'            => [_('Alt. subunit'), 'max:16'],
			'unicode_decimal'     => [_('Unicode decimal'), 'max:32'],
			'unicode_hexadecimal' => [_('Unicode hexadecimal'), 'max:16'],
		]);
	}

	// Relationships ===============================================================

	public function countries()
	{
		return $this->hasMany('App\Country');
	}

	public function users()
	{
		return $this->hasManyThrough('App\User', 'App\Country');
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Search this model
	 *
	 * @param  string $pattern
	 *
	 * @return \Illuminate\Database\Eloquent\Collection (of Currency)
	 */
	public static function search($pattern)
	{
		// Apply parameter grouping http://laravel.com/docs/queries#advanced-wheres
		return self::where(function ($query) use ($pattern) {

			// If pattern is a number search in the numeric columns
			if(is_numeric($pattern))
				$query->orWhere('id', $pattern);
			elseif(strlen($pattern) === 3)
				$query->orWhere('code', $pattern);

			// In any other case search in all the relevant columns
			$query->orWhere('name', 'LIKE', "%$pattern%")->orWhere('name2', 'LIKE', "%$pattern%");

		})->orderBy('name')->get();
	}

	// Logic =======================================================================

	/**
	 * Format currency $number for humans, adding digit separators and currency sybol.
	 *
	 * @param  float
	 * @param  integer
	 *
	 * @return string
	 */
	public function format($number, $precision = 2)
	{
		return currency($number, $this, $precision);
	}
}
