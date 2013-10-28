<?php

class HomeController extends BaseController {

	protected $layout = 'layouts.base';

	/**
	 * Show main page
	 *
	 * @return Response
	 */
	public function showMainPage()
	{
		$data = [
			'title' => _('Home'),
			'routes' => [],
		];

		// Select all GET routes wihtout parameters excluding admin.*
		foreach(App::make('router')->getRoutes() as $name => $route)
		{
			$url = $route->getPath();
			if (substr($name, 0, 6) != 'admin.' and false === strpos($url, '{') and in_array('GET', $route->getMethods()))
				$data['routes'][$name] = $url;
		}

		$this->layout->title = $data['title'];
		$this->layout->content = View::make('home.home', $data);
	}

	/**
	 * Show main page
	 *
	 * @return Response
	 */
	public function showAdminPage()
	{
		$data = [
			'title' => _('Admin'),
			'routes' => [],
		];

		// Select all admin.*.index routes
		foreach(App::make('router')->getRoutes() as $name => $route)
		{
			if($name == 'home' or preg_match('/^admin\..*\.index$/', $name))
				$data['routes'][$name] = $route->getPath();
		}

		$this->layout->title = $data['title'];
		$this->layout->content = View::make('home.home', $data);
	}

	/**
	 * Show contact form
	 *
	 * @return Response
	 */
	public function showContactForm()
	{
		$this->layout->title = _('Contact us');
		$this->layout->content = View::make('home.contact');
	}

	/**
	 * Process contact form and send the contact email
	 *
	 * @return Response
	 */
	public function sendContactEmail()
	{
		$rules = [
			'name' => 'required|max:50',
			'company' => 'max:50',
			'email' => 'required|email',
			'phone' => 'min:6|max:64',
			'message' => 'required|min:10|max:1000',
		];

		$input = Input::only(array_keys($rules));
		$validator = Validator::make($input, $rules);

		if($validator->fails())
			return Redirect::back()->withInput($input)->withErrors($validator);

		$message = $input['message'] . "\n\n" . $input['name'] . "\n" . $input['company'] . "\n" . $input['phone'];

		Mail::send(array('text' => 'emails.plain-text'), ['text' => $message], function($message) use ($input) {
			$message->from($input['email'], $input['name'])->to(Config::get('site.contact-email'), Config::get('site.name'))->subject(_('Contact form query'));
		});

		View::share('success', _('Message sent!'));
		$this->showContactForm();
	}
}
