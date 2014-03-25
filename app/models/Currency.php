<?php

class Currency extends BaseModel {

	public $timestamps = false;
	protected $softDelete = true;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');

	// Meta ========================================================================

	public function singular() { return _('Currency');}	// Singular form of this model's name
	public function plural() { return _('Currencies');}	// Singular name of this model's name
	public function __toString() { return $this->code;}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'code' => [_('Code'), 'required|size:3|regex:/^[A-Z]+$/|unique'], // ISO 4217
			'name' => [_('Name'), 'required|max:64'],
			'name2' => [_('Alt. name'), 'max:64'],
			'symbol' => [_('Symbol'), 'max:8'],
			'symbol2' => [_('Alt. symbol'), 'max:8'],
			'symbol_position' => [_('Symbol position'), 'required|integer'],
			'decimal_separator' => [_('Decimal separator'), 'size:1'],
			'thousands_separator' => [_('Thousands separator'), 'size:1'],
			'subunit' => [_('Subunit'), 'max:16'],
			'subunit2' => [_('Alt. subunit'), 'max:16'],
			'unicode_decimal' => [_('Unicode decimal'), 'max:32'],
			'unicode_hexadecimal' => [_('Unicode hexadecimal'), 'max:16'],
		));
	}

	// Relationships ===============================================================

	public function countries()
	{
		return $this->hasMany('Country');
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Search this model
	 *
	 * @param  string $query
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public static function search($query)
	{
		if(is_numeric($query))
			return new Illuminate\Database\Eloquent\Collection;

		$search = self::where('name', 'LIKE', "%$query%")->orWhere('name2', 'LIKE', "%$query%");
		
		if(strlen($query) == 3)
			$search->orWhere('code',$query);

		return $search->orderBy('name')->get();;
	}

	// Logic =======================================================================

	/**
	 * Adds digit separators and currency sybol.
	 *
	 * @param  float
	 * @param  integer
	 * @return void
	 */
	public function format($number, $precision = 2)
	{
		$formated = number_format($number, $precision, (string) $this->decimal_separator, (string) $this->thousands_separator);

		if( ! strlen($this->symbol))
			return $formated;

		return ($this->symbol_position) ? $formated . ' ' . $this->symbol : $this->symbol . ' ' . $formated;
	}
}
