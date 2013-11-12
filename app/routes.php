<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('test', function() {

	$validator = Validator::make(array('xxxx' => 'aaaa'),array('xxxx' => 'required|max_length:3'));
	if ($validator->fails())
		return $validator->messages()->all();

	return 'ok';
});

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showMainPage'));

// Contact us area
Route::get('contact', array('as' => 'contact', 'uses' => 'HomeController@showContactForm'));
Route::post('contact', array('as' => 'send.contact.email', 'uses' => 'HomeController@sendContactEmail'));

// Auth area
Route::get('login', array('before' => 'guest', 'as' => 'login', 'uses' => 'AuthController@showLoginForm'));
Route::post('login', array('before' => 'guest', 'uses' => 'AuthController@doLogin'));
Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@doLogout'));

// Admin area
Route::group(array('prefix' => 'admin', 'before' => ['auth', 'acl']), function() {

	Route::get('/', array('as' => 'admin', 'uses' => 'AdminController@showAdminPage'));

	Route::resource('accounts', 'AccountsController');
	Route::resource('authproviders', 'AuthProvidersController');
	Route::resource('countries', 'CountriesController');
	Route::resource('languages', 'LanguagesController');
	Route::resource('profiles', 'ProfilesController');
	Route::resource('users', 'UsersController');
});
