<?php namespace App\Composers;

use Auth;

class MasterMenuComposer
{
	public function compose($view)
	{
		// Build sections that will be available in all views that use master layout.

		if(Auth::check())
			$sections[Auth::user()->name()] = [
				link_to_route('admin', _('Dashboard')),
				link_to_route('logout', _('Logout')),
				link_to_route('contact', _('Contact')),
			];
		else
			$sections[_('Sections')] = [
				link_to_route('login', _('Login')),
				link_to_route('contact', _('Contact')),
			];

		// Pass sections to the view
		$view->with('sections', $sections);
	}
}
