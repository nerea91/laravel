<?php namespace App\Http\Controllers;

use Config;
use Input;
use Mail;
use Redirect;
use Validator;
use View;

class HomeController extends Controller
{
	protected $layout = 'layouts.master';

	/**
	 * Show main page
	 *
	 * @return Response
	 */
	public function showMainPage()
	{
		$this->layout->title = $title = _('Home');
		$this->layout->content = View::make('home.home')->withTitle($title);
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

		$labels = [
			'name' => _('Name'),
			'company' => _('Company'),
			'email' => _('E-mail'),
			'phone' => _('Phone'),
			'message' => _('Message'),
		];

		$input = Input::only(array_keys($rules));
		$validator = Validator::make($input, $rules)->setAttributeNames($labels);

		if($validator->fails())
			return Redirect::back()->withInput($input)->withErrors($validator);

		$message = $input['message'] . "\n\n" . $input['name'] . "\n" . $input['company'] . "\n" . $input['phone'];

		Mail::send(array('text' => 'emails.plain-text'), ['text' => $message], function ($message) use ($input) {
			$message->from($input['email'], $input['name'])->to(Config::get('site.contact-email'), Config::get('site.name'))->subject(_('Contact form query'));
		});


		return Redirect::back()->withSuccess(_('Your query has been sent!'));
	}
}
