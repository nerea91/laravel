<?php

class HomeController extends BaseController {

	protected $layout = 'layouts.base';

	public function index()
	{
		$data = array(
			'title' => 'Laravel 4',
			'description' => 'Home page'
		);

		$this->layout->content = View::make('home.index', $data);
	}
}
