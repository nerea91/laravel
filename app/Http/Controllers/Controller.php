<?php namespace App\Http\Controllers; namespace App\Http\Controllers;

use Illuminate\Routing\Controller as UpstreamController;
use View;

class Controller extends UpstreamController
{
	/**
	 * Common constructor for all our controllers
	 */
	public function __construct()
	{
		// Enable CSRF for all controllers
		$this->beforeFilter('csrf', array('on' => 'post', 'put', 'patch', 'delete'));

		// Setup the layout used by the controller
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
}
