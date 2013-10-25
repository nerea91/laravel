<?php

class Language extends Way\Database\Model {

	protected $softDelete = true;
	protected $guarded = array('deleted_at');

	public $timestamps = false;
	public static $rules = array(
		'code' => 'required|alpha|size:2|unique',
		'name' => 'required|max:32|unique',
		'english_name' => 'required|max:32|unique',
		'locale' => 'required|size:5|regex:/[a-z]+_[A-Z]+/',
		'default' => 'required|integer|min:0|max:1',
		'priority' => 'required|integer'
	);

	// Relationships ==========================================================

	// Static Methods =========================================================

	/**
	 * Detect the language from the URL subdomain or the clients browser.
	 *
	 * If no language is detected or the detected one does not exist
	 * on the DB then the default language will be returned.
	 *
	 * @param  string $url
	 * @return Language
	 */
	public static function detect($url)
	{
		//Get all languages from data base
		$all = self::getAllByPriority();
		if( ! $all->count())
			return new Language;

		//Assume first language as the default one
		$default = $all->first();

		//Extract subdomain from url
		preg_match('/^([a-z][a-z])\./', parse_url($url)['host'], $matches);

		//If subdomain found check if it's valid
		if(isset($matches[1]) AND ! is_null($lang = self::findByLocaleOrCode($matches[1], $all)))
		{
			$lang->detected_from = 'subdomain';
			return $lang;
		}

		//No luck with the subdomain, try now with the browser
		if( ! isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) OR $_SERVER['HTTP_ACCEPT_LANGUAGE'] == '')
		{
			$default->detected_from = 'default (browser languages not available)';
			return $default;
		}

		$browser_languages = explode(',', preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE']))));
		foreach($browser_languages as $lang)
		{
			$lang = self::findByLocaleOrCode($lang, $all);
			if( ! is_null($lang))
			{
				$lang->detected_from = 'browser';
				return $lang;
			}
		}

		//Fallback to default
		$default->detected_from = "default (browser doesn't have any known language)";
		return $default;
	}

	/**
	 * Return the first Language from $haystack whose locale or code matches $needle.
	 *
	 * Returns null if not found.
	 *
	 * @param  string $needle
	 * @param  Illuminate\Database\Eloquent\Collection $haystack
	 * @return mixed string|null
	 */
	private static function findByLocaleOrCode($needle, $haystack)
	{
		//Normalize
		$needle = strtolower(str_replace('-', '_', $needle));

		foreach($haystack as $lang)
		{
			if(strtolower($lang->locale) == $needle OR $lang->code == $needle)
				return $lang;
		}

		return null;
	}

	/**
	 * Get all enabled languages sorted by priority
	 *
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public static function getAllByPriority()
	{
		return self::orderBy('default', 'desc')->orderBy('priority')->remember(60*12 /*12 hours*/)->get();
	}

	// Logic ==================================================================

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

		//if($current_locale === false)
		//	App::abort(500, sprintf('Failed to set %s locate: The locale does not exist on your system, the category name is invalid or the locale functionality is not implemented on your platform.', $locale));

		return $this;
	}

}
