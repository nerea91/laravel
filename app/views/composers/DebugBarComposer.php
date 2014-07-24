<?php

class DebugBarComposer
{
	public function compose($view)
	{
		// Add debugbar if it's enabled
		if(App::bound('debugbar') and Config::get('laravel-debugbar::config.enabled', false))
		{
			Assets::add('debugbar');
			$view->with('debugbar', App::make('debugbar')->getJavascriptRenderer()->render());
		}
	}
}
