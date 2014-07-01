<?php

return array(

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

	'mailgun' => array(
		'domain' => '',
		'secret' => '',
	),

	'mandrill' => array(
		'secret' => '',
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => '',
	),

	'facebook' => array(
		'client_id'     => 'to-do',
		'client_secret' => 'to-do',
		'scope'         => array('email'),
	),

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

);
