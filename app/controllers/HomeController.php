<?php

class HomeController extends BaseController {

	protected $layout = 'layouts.base';

	public function index()
	{
		$this->layout->title = 'Laravel 4';
		$this->layout->content = View::make('home.index')->withRoutes(App::make('router')->getRoutes());
	}
}
