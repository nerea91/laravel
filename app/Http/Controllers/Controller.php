<?php namespace App\Http\Controllers; namespace App\Http\Controllers;

class Controller extends Illuminate\Routing\Controller
{
	/**
	 * Common constructor for all our controllers
	 */
	public function __construct()
	{
		parent::__construct();

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
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
}
