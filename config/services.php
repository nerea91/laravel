<?php

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

	/*
	'facebook' => [
		'client_id'     => '',
		'client_secret' => '',
		'scope'         => ['email'],
	],

	'google' => [
		'client_id'     => '',
		'client_secret' => '',
		'scope'         => ['profile', 'email'],
	],
	*/


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