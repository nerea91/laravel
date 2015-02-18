<?php

// Base URL for social login
$url = 'https://laravel.dev/login/with/'; //to-do customice for your application needs

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

	'facebook' => [
		'client_id'     => env('FACEBOOK_OAUTH_CLIENT_ID'),
		'client_secret' => env('FACEBOOK_OAUTH_CLIENT_SECRET'),
		'redirect'      => $url . 'facebook',
		'scopes'        => ['email'],
	],

	'github' => [
		'client_id'     => env('GITHUB_OAUTH_CLIENT_ID'),
		'client_secret' => env('GITHUB_OAUTH_CLIENT_SECRET'),
		'redirect'      => $url . 'github',
		'scopes'        => ['user:email'],
	],

	'google' => [
		'client_id'     => env('GOOGLE_OAUTH_CLIENT_ID'),
		'client_secret' => env('GOOGLE_OAUTH_CLIENT_SECRET'),
		'redirect'      => $url . 'google',
		'scopes'        => ['profile', 'email'],
	],

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],

];
