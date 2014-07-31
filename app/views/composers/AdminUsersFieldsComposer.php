<?php

class AdminUsersFieldsComposer
{
	public function compose($view)
	{
		// Selectable profiles
		$view->with('profiles', Auth::user()->profile->getSimilarOrInferior()->sortBy('name')->lists('name', 'id'));
	}
}
