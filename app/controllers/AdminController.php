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
		$this->layout->title = _('Admin');
		$this->layout->subtitle = _('Panel');
		$this->layout->content = Response::make();
	}

}
