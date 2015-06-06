<?php namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
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

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setRules([
			'title' => [_('Title'), 'required|max:255|unique'],
			'body'  => [_('Body'), 'required'],
		]);
	}

	// Relationships ===============================================================

	public function profiles()
	{
		return $this->belongsToMany('App\Profile');
	}

	// Events ======================================================================

	public static function boot()
	{
		// NOTE saving   -> creating -> created   -> saved
		// NOTE saving   -> updating -> updated   -> saved
		// NOTE deleting -> deleted  -> restoring -> restored

		parent::boot(); // Validate the model

		static::saved(function ($doc) {
			Profile::purgeDocumentsCache();
		});

		static::deleted(function ($doc) {
			Profile::purgeDocumentsCache();
		});

		static::restored(function ($doc) {
			Profile::purgeDocumentsCache();
		});
	}

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
		return self::where('title', 'LIKE', "%$pattern%")->orderBy('title')->get();
	}

	// Logic =======================================================================
}
