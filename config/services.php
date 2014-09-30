<?php

$socialLoginBaseUrl = 'https://dev.laravel.es/login/with/'; //to-do

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],

	//Dev URL: https://github.com/settings/applications
	'github' => [
		'client_id'     => '',
		'client_secret' => '',
		'redirect'      => $socialLoginBaseUrl . 'github',
	],

	//Dev URL: https://developers.facebook.com/apps
	'facebook' => [
		'client_id'     => '',
		'client_secret' => '',
		'redirect'      => $socialLoginBaseUrl . 'facebook',
		'scopes'         => ['email'],
	],

	// Dev URL: https://code.google.com/apis/console/
	'google' => [
		'client_id'     => '.apps.googleusercontent.com',
		'client_secret' => '',
		'redirect'      => $socialLoginBaseUrl . 'google',
		'scopes'         => ['profile', 'email'],
	],


	/*
	|--------------------------------------------------------------------------
	| Google analytics
	|--------------------------------------------------------------------------
	|
	| If you have a Google analytics account uncomment next line and replace
	| UA-XXXXX-X with your web property ID. The Google analytics javascript
	| will be automatically added to the bottom of the base layout.
	|
	*/

	//'googleanalytics' => 'UA-XXXXX-X', //to-do

];
