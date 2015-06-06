<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
	/**
	 * Common constructor for all controllers.
	 */
	public function __construct()
	{
		// Setup the layout used by the controller
		if(is_string($this->layout))
			$this->layout = view($this->layout);
	}

	/**
	 * Attach view to layout.
	 *
	 * @param  string $view
	 * @param  array  $data
	 *
	 * @return \Illuminate\View\View
	 * @throws \InvalidArgumentException
	 */
	public function layout(\Illuminate\View\View $view, array $data = [])
	{
		// Sanity check
		if(array_key_exists('content', $data))
			throw new \InvalidArgumentException('Content keyword is reserved');

		// Add optional data to the layout
		foreach($data as $key => $value)
			$this->layout->$key = $value;

		// Attach view to layout
		$this->layout->content = $view;

		// Return controller layout
		return $this->layout;
	}
}
