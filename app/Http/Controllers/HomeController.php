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
		// Add data to the layout
		$this->layout->title = _('Home');

		// Return layout + view
		return $this->layout(view('home.home'));
	}

	/**
	 * Show contact form
	 *
	 * @return Response
	 */
	public function showContactForm()
	{
		// Add data to the layout
		$this->layout->title = _('Contact us');

		// Return layout + view
		return $this->layout(view('home.contact'));
	}

	/**
	 * Process contact form and send the contact email
	 *
	 * @return Response
	 */
	public function sendContactEmail()
	{
		// Validate form
		$rules = [
			'name'    => 'required|max:50',
			'company' => 'max:50',
			'email'   => 'required|email',
			'phone'   => 'min:6|max:64',
			'message' => 'required|min:10|max:1000',
		];

		$labels = [
			'name'    => _('Name'),
			'company' => _('Company'),
			'email'   => _('E-mail'),
			'phone'   => _('Phone'),
			'message' => _('Message'),
		];

		$input = Input::only(array_keys($rules));
		$validator = Validator::make($input, $rules)->setAttributeNames($labels);

		if($validator->fails())
			return redirect()->back()->withInput($input)->withErrors($validator);

		// Send e-mail
		$text = $input['message'] . "\n\n" . $input['name'] . "\n" . $input['company'] . "\n" . $input['phone'];

		Mail::raw($text, function ($message) use ($input) {
			$message->from($input['email'], $input['name'])->to(config('site.contact-email'), config('site.name'))->subject(_('Contact form query'));
		});

		return redirect()->back()->withSuccess(_('Your query has been sent!'));
	}
}
