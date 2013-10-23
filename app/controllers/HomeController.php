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
		$this->layout->title = 'Laravel 4';
		$this->layout->content = View::make('home.index')->withRoutes(App::make('router')->getRoutes());
	}

	/**
	 * Show contact form
	 *
	 * @return Response
	 */
	public function showContactForm()
	{
		$this->layout->title = _('Contact us');
		$this->layout->content = View::make('home.contact_form');
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
