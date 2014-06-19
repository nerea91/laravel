<?php

class LoginFormComposer
{
	public function compose($view)
	{
		// All languages but current one
		$appLanguage = App::make('language');

		$languages = Language::getAllByPriority()->filter(function ($l) use ($appLanguage) {
			return $l->id != $appLanguage->id;
		});

		$view->with('languages', $languages);
	}
}
