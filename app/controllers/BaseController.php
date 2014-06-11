<?php

class BaseController extends Controller
{
	/**
	 * Common constructor for all our controllers
	 */
	public function __construct()
	{
		// Enable CSRF for all controllers
		$this->beforeFilter('csrf', array('on' => 'post', 'put', 'patch', 'delete'));
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
}
