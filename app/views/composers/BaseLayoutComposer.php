<?php

class BaseLayoutComposer
{

	public function compose($view)
	{
		// Application language
		$view->with('lang', App::make('language'));

		// Populate languages for implementing https://support.google.com/webmasters/answer/189077
		$url = parse_url(Request::url());
		$domain = preg_replace('/^[a-z][a-z]\./', '', $url['host']);
		$languages = Language::getAllByPriority();
		foreach($languages as &$l)
		{
			//Regenerate URL
			$url['host'] = $l->code . '.' . $domain;
			$l->url = http_build_url($url);
		}
		$view->with('languages', $languages);

		// Add PHP debugbar
		if ($debugbar = Config::get('laravel-debugbar::config.enabled', false))
		{
			Assets::add('debugbar');
			$view->with('debugbar', App::make('debugbar')->getJavascriptRenderer()->render());
		}
	}
}
