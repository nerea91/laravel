<?php

class Language extends Way\Database\Model {

	protected $softDelete = true;

	public $timestamps = false;
	public static $rules = array(
		'code' => 'required|alpha|size:2',
		'name' => 'required|max:32',
		'english_name' => 'required|max:32',
		'locale' => 'required|size:5',
		'default' => 'required|integer|min:0|max:1',
		'priority' => 'required|integer'
	);

	/**
	* Detects and sets language according to a route prefix.
	*
	* If no prefix is supplied it will try to detect browser language.
	* If the language is unknown it will fallback to the default language.
	*
	* The second parameter determines weather or not the default language will have a prefix
	*
	* @param  string $route_prefix current route prefix
	* @param  bool $default_uses_prefix
	* @return string prefix used for all routes
	*/
	public static function prefix($route_prefix, $default_uses_prefix = FALSE)
	{
		//Get all languages from data base
		$all = self::orderBy('default', 'desc')->orderBy('priority')->get()->toArray();
		$languages = array_fetch($all, 'code');
		$locales = array_combine($languages, array_fetch($all, 'locale')); //$lang => $locale

		//Assume first language as the default one
		$default = head($languages);

		//If language is unknown try to detect it from browser
		if(strlen($route_prefix) != 2 OR ! in_array($route_prefix, $languages))
			$route_prefix = self::detectBrowserLanguage($languages, $default);

		//Set language and locale
		self::setLocale($route_prefix, $locales[$route_prefix]);

		if( ! $default_uses_prefix AND $route_prefix == $default)
			return null;

		return $route_prefix;
	}

	/**
	 * Returns the first browser language that matches one of the provided ones.
	 *
	 * If no language matches returns the default one.
	 *
	 * @param array $languages Supported languages
	 * @param string $default Default language
	 * @return string
	 */
	private static function detectBrowserLanguage($languages, $default)
	{
		//Is browser language available?
		if( ! isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) OR $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '')
			return $default;

		//Get browser languages
		$browser_languages = explode(',', preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE']))));

		//Normalize names
		foreach($browser_languages as $key => $value)
			$browser_languages[$key] = strtolower(substr($value, 0, 2));

		//Check against the available languages
		foreach(array_unique($browser_languages) as $lang)
			if(in_array($lang, $languages))
				return $lang;

		//No luck
		return $default;
	}

	/**
	 * Sets the language for both gettext and Laravel
	 *
	 *
	 * @param  string $lang Laravel app.locale
	 * @param  integer $locale gettext setlocale
	 * @return boolean
	 */
	public static function setLocale($lang, $locale)
	{
		//Language for laravel
		App::setLocale($lang);

		//Language for gettext
		$res = setlocale(LC_ALL, "$locale.UTF-8", "$locale.utf-8", "$locale.utf8", "$locale UTF8", "$locale UTF-8", "$locale utf-8", "$locale utf8", "$locale UTF8", $locale);
		//NOTE: LC_ALL may switch float decimal separator character deppending on locale which could have undesired issues specially when inserting float values to your DB. Consider using LC_MESSAGES instead

// 		if($res === false)
// 			throw new Exception(sprintf("The locale functionality is not implemented on your platform, the '$locale' locale does not exist or the category name is invalid."));

		return $res !== false;
	}
}
