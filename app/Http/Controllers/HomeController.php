<?php namespace App\Http\Controllers;

use Input;
use Mail;
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
		$this->layout->content = view('home.home')->withTitle($title);
	}

	/**
	 * Show contact form
	 *
	 * @return Response
	 */
	public function showContactForm()
	{
		$this->layout->title = _('Contact us');
		$this->layout->content = view('home.contact');
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
			return redirect()->back()->withInput($input)->withErrors($validator);

		$message = $input['message'] . "\n\n" . $input['name'] . "\n" . $input['company'] . "\n" . $input['phone'];

		Mail::send(array('text' => 'emails.plain-text'), ['text' => $message], function ($message) use ($input) {
			$message->from($input['email'], $input['name'])->to(config('site.contact-email'), config('site.name'))->subject(_('Contact form query'));
		});


		return redirect()->back()->withSuccess(_('Your query has been sent!'));
	}
}
