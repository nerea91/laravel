<?php

class AdminController extends BaseController {

	protected $layout = 'layouts.admin';

	/**
	 * Show admin control panel main page
	 *
	 * @return Response
	 */
	public function showAdminPage()
	{
		$this->layout->title = _('Admin panel');
		$this->layout->subtitle = _('Search');
		$this->layout->content = View::make('admin.search');
	}

}
