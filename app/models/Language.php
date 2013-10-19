<?php

class Language extends Model {

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

	// Logic ==================================================================

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
		$all = self::orderBy('default', 'desc')->orderBy('priority')->remember(60*24)->get();
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
			$default->detected_from = 'default (HTTP_ACCEPT_LANGUAGE not available)';
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
		$default->detected_from = 'default';
		return $default;
	}


	/**
	 * Set the language for Gettext
	 *
	 * Reruns TRUE on success of FALSE if the locale functionality is not implemented on your platform
	 * or the locale does not exist or the category name is invalid.
	 *
	 * @return boolean
	 */
	public function setLocale()
	{
		if( ! $this->code OR ! $this->locale)
			return false;

		//Language for Laravel based translations
		//App::setLocale($this->code);

		//Language for PHP Gettext
		bindtextdomain('messages', app_path().'/lang/');
		textdomain('messages');
		$locale = $this->locale;

		/* NOTE:
		LC_ALL may switch float decimal separator character deppending on locale which could have undesired issues specially when
		inserting float values to your DB. Consider using LC_MESSAGES instead */
		$res = setlocale(LC_ALL, "$locale.UTF-8", "$locale.utf-8", "$locale.utf8", "$locale UTF8", "$locale UTF-8", "$locale utf-8", "$locale utf8", "$locale UTF8", $locale);

		return $res !== false;
	}


	/**
	 * Return the first Language from $haystack whose locale or code matches $needle.
	 *
	 * Returns null if not found.
	 *
	 * @param  string $needle
	 * @param  Illuminate\Database\Eloquent\Collection $haystack
	 * @return mixed
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
}
