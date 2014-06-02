<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Language extends BaseModel
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
		return _('Language');
	}

	/**
	 * Plural form of this model's name
	 *
	 * @return string
	 */
	public function plural()
	{
		return _('Languages');
	}

	/**
	 * What should be returned when this model is casted to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->english_name;
	}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'code' => [_('Code'), 'required|size:2|regex:/^[a-z]+$/|unique'],
			'name' => [_('Name'), 'required|alpha|max:32|unique'],
			'english_name' => [_('English name'), 'required|alpha|max:32|unique'],
			'locale' => [_('Locale'), 'required|size:5|regex:/^[a-z]+_[A-Z]+$/'],
			'is_default' => [_('Default'), 'required|integer|min:0|max:1'],
			'priority' => [_('Priority'), 'required|integer'],
		));
	}

	// Relationships ===============================================================

	public function users()
	{
		return $this->hasMany('User');
	}

	// Events ======================================================================

	public static function boot()
	{
		// NOTE saving   -> creating -> created   -> saved
		// NOTE saving   -> updating -> updated   -> saved
		// NOTE deleting -> deleted  -> restoring -> restored

		parent::boot();

		static::saved(function ($language) {

			// Only one Language can be the default
			if($language->is_default)
				Language::where('id', '<>', $language->id)->update(array('is_default' => 0));

			// Purge cache
			Cache::forget('allLanguagesOrderedByPriority');
		});

		static::deleted(function ($language) {

			// Purge cache
			Cache::forget('allLanguagesOrderedByPriority');
		});

	}

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Search this model
	 *
	 * @param  string $query
	 * @return Illuminate\Database\Eloquent\Collection (of Language)
	 */
	public static function search($query)
	{
		if(is_numeric($query))
			return new Illuminate\Database\Eloquent\Collection;

		$search = self::where('name', 'LIKE', "%$query%")->orWhere('english_name', 'LIKE', "%$query%");

		if(strlen($query) == 2)
			$search->orWhere('code', $query);

		if(strlen($query) <= 5)
			$search->orWhere('locale', $query);

		return $search->orderBy('english_name')->get();
	}

	/**
	 * Determine the language of the application.
	 *
	 * - First try with previous value from session.
	 * - Sencond try with the URL subdomain.
	 * - Third try with the clients browser.
	 *
	 * If no language is detected or the detected one does not exist
	 * on the DB then the default language will be returned.
	 *
	 * @return Language
	 */
	public static function detect()
	{
		// Get all languages from data base
		$all = self::getAllByPriority();
		if( ! $all->count())
			return new Language;

		// Try with previous value from session
		if(Session::has('language'))
		{
			$lang = Session::get('language');
			if(isset($lang->id) and $all->contains($lang->id))
			{
				$lang = $all->find($lang->id);
				$lang->detectedFrom = 'session';
				return $lang;
			}
		}

		// Extract subdomain from url
		$url = Request::url();
		preg_match('/^([a-z][a-z])\./', parse_url($url)['host'], $matches);

		// If subdomain found check if it's valid
		if(isset($matches[1]) and ! is_null($lang = self::findByLocaleOrCode($matches[1], $all)))
		{
			$lang->detectedFrom = 'subdomain';
			return $lang;
		}

		// No luck so far, prepare a default to fallback.
		$default = $all->first();

		// Try with the browser
		if( ! isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) or $_SERVER['HTTP_ACCEPT_LANGUAGE'] == '')
		{
			$default->detectedFrom = 'default (browser languages not available)';
			return $default;
		}

		$browser_languages = explode(',', preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE']))));
		foreach($browser_languages as $lang)
		{
			$lang = self::findByLocaleOrCode($lang, $all);
			if( ! is_null($lang))
			{
				$lang->detectedFrom = 'browser';
				return $lang;
			}
		}

		// Fallback to default
		$default->detectedFrom = "default (browser doesn't have any known language)";
		return $default;
	}

	/**
	 * Get all enabled languages sorted by priority
	 *
	 * @return Illuminate\Database\Eloquent\Collection (of Language)
	 */
	public static function getAllByPriority()
	{
		return self::orderBy('is_default', 'desc')->orderBy('priority')->remember(60 * 12 /*12 hours*/, 'allLanguagesOrderedByPriority')->get();
	}

	/**
	 * Return the first Language from $haystack whose locale or code matches $needle.
	 *
	 * Returns null if not found.
	 *
	 * @param  string $needle
	 * @param  Illuminate\Database\Eloquent\Collection (of Language) $haystack
	 * @return Language|null
	 */
	private static function findByLocaleOrCode($needle, $haystack)
	{
		// Normalize
		$needle = strtolower(str_replace('-', '_', $needle));

		foreach($haystack as $lang)
		{
			if(strtolower($lang->locale) == $needle or $lang->code == $needle)
				return $lang;
		}

		return null;
	}

	// Logic =======================================================================

	/**
	 * Determine whether or not the model can be deleted.
	 *
	 * @param  boolean $throwExceptions
	 * @return boolean
	 *
	 * @throws ModelDeletionException
	 */
	public function deletable($throwExceptions = false)
	{
		// Prevent deleting default language
		if($this->is_default)
		{
			if($throwExceptions)
				throw new ModelDeletionException(_('Deleting default language is not allowed'));
			return false;
		}

		return true;
	}

	/**
	 * Sort model by parameters given in the URL
	 * i.e: ?sortby=name&sortdir=desc
	 *
	 * @param Illuminate\Database\Eloquent\Builder
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOrderByUrl($query)
	{
		$column = Input::get('sortby');
		$direction = (Input::get('sortdir') == 'desc') ? 'desc' : 'asc';

		if($column == 'name')
			return $query->orderBy('english_name', $direction);

		return parent::scopeOrderByUrl($query);
	}

	/**
	 * Set the language for Gettext
	 *
	 * NOTE: LC_ALL may switch float decimal separator character deppending on locale. This could cause undesired issues
	 * specially when inserting float values to your data base. If that is your case consider using LC_MESSAGES instead.
	 *
	 * @param  $category see http://php.net/manual/en/function.setlocale.php
	 * @return Language
	 */
	public function setLocale($category = LC_ALL)
	{
		bindtextdomain('messages', app_path().'/lang/');
		textdomain('messages');
		$locale = $this->locale;

		$current_locale = setlocale($category, "$locale.UTF-8", "$locale.utf-8", "$locale.utf8", "$locale UTF8", "$locale UTF-8", "$locale utf-8", "$locale utf8", "$locale UTF8", $locale);

		// if($current_locale === false)
		//	App::abort(500, sprintf('Failed to set %s locate: The locale does not exist on your system, the category name is invalid or the locale functionality is not implemented on your platform.', $locale));

		return $this;
	}

	/**
	 * Convert to stdClass object
	 *
	 * @return stdClass
	 */
	public function toObject()
	{
		return (object) $this->toArray();
	}
}
