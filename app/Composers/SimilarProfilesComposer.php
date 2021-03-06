<?php namespace App\Composers;

class SimilarProfilesComposer
{
	public function compose($view)
	{
		// Selectable profiles
		$view->with('profiles', auth()->user()->profile->getSimilarOrInferior()->sortBy('name')->pluck('name', 'id')->all());
	}
}
