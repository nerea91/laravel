<?php namespace App\Composers;

use Auth;

class SimilarProfilesComposer
{
	public function compose($view)
	{
		// Selectable profiles
		$view->with('profiles', Auth::user()->profile->getSimilarOrInferior()->sortBy('name')->lists('name', 'id')->all());
	}
}
