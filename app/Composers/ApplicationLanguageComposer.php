<?php namespace App\Composers;

use App\Language;
use Request;

class ApplicationLanguageComposer
{
	public function compose($view)
	{
		// Application language
		$view->with('appLanguage', $appLanguage = session('language'));

		// All languages (for implementing https://support.google.com/webmasters/answer/189077)
		$url = parse_url(Request::url());
		$domain = preg_replace('/^[a-z][a-z]\./', '', $url['host']);
		$languages = Language::getAllByPriority();
		foreach($languages as &$l)
		{
			// Regenerate URL
			$url['host'] = $l->code . '.' . $domain;
			$l->url = http_build_url($url);
		}
		$view->with('allLanguages', $languages);

		// All languages but current one
		$view->with('allLanguagesButCurrent', $languages->filter(function ($l) use ($appLanguage) {
			return $l->id != $appLanguage->id;
		}));
	}
}
