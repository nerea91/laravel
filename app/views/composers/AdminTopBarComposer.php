<?php

class AdminTopBarComposer
{
	public function compose($view)
	{
		// Authenticated user
		$view->with('user', $currentUser = Auth::user());

		// Application language
		$appLanguage = App::make('language');
		$view->with('language', $appLanguage);

		// All languages but current one
		$view->with('languages', Language::getAllByPriority()->filter(function ($l) use ($appLanguage) {
			return $l->id != $appLanguage->id;
		}));
	}
}
