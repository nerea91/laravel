<?php

class AdminUsersFieldsComposer
{
	public function compose($view)
	{
		// Only profiles similar to current user's profile can be selected
		$view->with('profiles', Auth::user()->profile->getSimilarOrInferior()->sortBy('name')->lists('name', 'id'));
	}
}
