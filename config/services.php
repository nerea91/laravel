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

	'facebook' => [
		'client_id'     => env('FACEBOOK_OAUTH_CLIENT_ID'),
		'client_secret' => env('FACEBOOK_OAUTH_CLIENT_SECRET'),
		'scopes'        => ['email'],
	],

	'github' => [
		'client_id'     => env('GITHUB_OAUTH_CLIENT_ID'),
		'client_secret' => env('GITHUB_OAUTH_CLIENT_SECRET'),
		'scopes'        => ['user:email'],
	],

	'google' => [
		'client_id'     => env('GOOGLE_OAUTH_CLIENT_ID'),
		'client_secret' => env('GOOGLE_OAUTH_CLIENT_SECRET'),
		'scopes'        => ['profile', 'email'],
	],

	'twitter' => [
		'client_id'     => env('TWITTER_OAUTH_CLIENT_ID'),
		'client_secret' => env('TWITTER_OAUTH_CLIENT_SECRET'),
	],

	'mailgun' => [
		'domain' => env('MAILGUN_DOMAIN'),
		'secret' => env('MAILGUN_SECRET'),
	],

	'mandrill' => [
		'secret' => env('MANDRILL_SECRET'),
	],

	'ses' => [
		'key'    => env('SES_KEY'),
		'secret' => env('SES_SECRET'),
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => App\User::class,
		'key'    => env('STRIPE_KEY'),
		'secret' => env('STRIPE_SECRET'),
	],

];
