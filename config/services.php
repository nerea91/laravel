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

	// Dev URL: https://github.com/settings/applications
	'github' => [
		'client_id'     => 'e892c0e6ff80d96af5e3',
		'client_secret' => '2f0b1655eb13dacb0c930b576c86c9028a35574e',
		'redirect'      => $socialLoginBaseUrl . 'github',
		'scopes'        => ['user:email'],
	],

	// Dev URL: https://developers.facebook.com/apps
	'facebook' => [
		'client_id'     => '905425069484205',
		'client_secret' => 'd5b9cf988c21dce153621fc20091e620',
		'redirect'      => $socialLoginBaseUrl . 'facebook',
		'scopes'        => ['email'],
	],

	// Dev URL: https://code.google.com/apis/console/
	'google' => [
		'client_id'     => '412679753310.apps.googleusercontent.com',
		'client_secret' => 'Vvbe-KuNVlUOcS1A3kIGDjoZ',
		'redirect'      => $socialLoginBaseUrl . 'google',
		'scopes'        => ['profile', 'email'],
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
