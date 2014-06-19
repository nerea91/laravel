<?php

class LoginFormComposer
{
	public function compose($view)
	{
		// Application language
		$appLanguage = App::make('language');
		$view->with('appLanguage', $appLanguage);

		// All languages but current one
		$languages = Language::getAllByPriority()->filter(function ($l) use ($appLanguage) {
			return $l->id != $appLanguage->id;
		});
		$view->with('languages', $languages);
	}
}
