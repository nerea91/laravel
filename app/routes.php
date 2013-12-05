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
// Home page
Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showMainPage'));

// Contact us area
Route::get('contact', array('as' => 'contact', 'uses' => 'HomeController@showContactForm'));
Route::post('contact', array('as' => 'contact.send', 'uses' => 'HomeController@sendContactEmail'));

// Auth area
Route::get('login', array('before' => 'guest', 'as' => 'login', 'uses' => 'AuthController@showLoginForm'));
Route::post('login', array('before' => 'guest', 'uses' => 'AuthController@doLogin'));
Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@doLogout'));

// User control panel
Route::group(array('prefix' => 'user', 'before' => 'auth'), function() {
	Route::get('options', array('as' => 'user.options', 'uses' => 'UserPanelController@showSettingsForm'));
	Route::put('options', array('as' => 'user.options.update', 'uses' => 'UserPanelController@showSettingsForm'));

	Route::get('password', array('as' => 'user.password', 'uses' => 'UserPanelController@showChangePasswordForm'));
	Route::put('password', array('as' => 'user.password.update', 'uses' => 'UserPanelController@updatePassword'));
});

// Admin area
Route::group(array('prefix' => 'admin', 'before' => ['auth', 'acl']), function() {

	// Admin panel home page
	Route::get('/', array('as' => 'admin', 'uses' => 'AdminController@showAdminPage'));

	// Resource controllers
	Route::resource('accounts', 'AccountsController');
	Route::resource('authproviders', 'AuthProvidersController');
	Route::resource('countries', 'CountriesController');
	Route::resource('currencies', 'CurrenciesController');
	Route::resource('languages', 'LanguagesController');
	Route::resource('profiles', 'ProfilesController');
	Route::resource('users', 'UsersController');

});
