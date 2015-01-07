<?php namespace App;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Document extends Model
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
		return _('Document');
	}

	/**
	 * Plural form of this model's name
	 *
	 * @return string
	 */
	public function plural()
	{
		return _('Documents');
	}

	/**
	 * What should be returned when this model is casted to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->title;
	}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'title' => [_('Title'), 'required|max:255|unique'],
			'body' => [_('Body'), 'required'],
		));
	}

	// Relationships ===============================================================

	public function profiles()
	{
		return $this->belongsToMany('App\Profile');
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
		return self::where('title', 'LIKE', "%$pattern%")->orderBy('title')->get();
	}

	// Logic =======================================================================
}
