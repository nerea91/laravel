<?php namespace App\Http\Controllers;

use Illuminate\View\View;

class Controller
{
	/**
	 * Common constructor for all our controllers.
	 */
	public function __construct()
	{
		// Setup the layout used by the controller
		$this->setupLayout();
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @param  string $layout
	 * @return Controller
	 */
	public function setupLayout($layout = null)
	{
		$this->layout = view(($layout) ?: $this->layout);

		return $this;
	}

	/**
	 * Attach view to layout.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @throws \InvalidArgumentException
	 */
	public function layout(View $view, array $data = [])
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
