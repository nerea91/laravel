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

// Change application language
Route::get('language/{code}', array('as' => 'language.set', function ($code) {
	if($language = Language::whereCode($code)->first())
		$language->remember();

	return Redirect::to(URL::previous() ?: route('home'));
}))->where('code', '^[a-z][a-z]$');

// Contact us area
Route::get('contact', array('as' => 'contact', 'uses' => 'HomeController@showContactForm'));
Route::post('contact', array('as' => 'contact.send', 'uses' => 'HomeController@sendContactEmail'));

// Guest user area
Route::group(array('https', 'before' => 'guest', 'prefix' => 'login'), function () {

	// Login with native autencication
	Route::get('/', array('as' => 'login', 'uses' => 'AuthController@showLoginForm'));
	Route::post('/', array('uses' => 'AuthController@login'));

	// Login with Oauth provider
	Route::get('with/{provider}', array('as' => 'login.oauth', 'uses' => 'AuthController@oauthLogin'));

});

// Authenticated user area
Route::group(array('https', 'before' => 'auth'), function () {

	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));

	// Current user control panel
	Route::group(array('prefix' => 'user'), function () {
		Route::get('options', array('as' => 'user.options', 'uses' => 'UserPanelController@showOptionsForm'));
		Route::put('options', array('as' => 'user.options.update', 'uses' => 'UserPanelController@updateOptions'));
		Route::get('password', array('as' => 'user.password', 'uses' => 'UserPanelController@showChangePasswordForm'));
		Route::put('password', array('as' => 'user.password.update', 'uses' => 'UserPanelController@updatePassword'));
		Route::get('regional', array('as' => 'user.regional', 'uses' => 'UserPanelController@showRegionalForm'));
		Route::put('regional', array('as' => 'user.regional.update', 'uses' => 'UserPanelController@updateRegional'));
	});

	// Admin area
	Route::group(array('prefix' => 'admin'), function () {
		Route::get('/', array('as' => 'admin',  'uses' => 'AdminController@showAdminPage'));
		Route::post('/', array('as' => 'admin.search', 'uses' => 'AdminController@search'));

		// Resource controllers require ACL
		Route::group(array('before' => 'acl'), function () {
			Route::resource('accounts', 'AccountsController');
			Route::resource('authproviders', 'AuthProvidersController');
			Route::resource('countries', 'CountriesController');
			Route::resource('currencies', 'CurrenciesController');
			Route::resource('languages', 'LanguagesController');
			Route::resource('profiles', 'ProfilesController');
			Route::resource('users', 'UsersController');
		});

	});

});

// Route for testings purposes, oly available on local environment
Route::get('test', array('before' => 'local', function () {

	// Define some variables
	$user = User::first()->toArray();
	$language = Language::first()->toArray();

	// Choose which ones of the above will be shown
	$pleaseShowThese = compact('user', 'language');

	// ==== DO NOR MODIFY BELOW HERE ================================

	$tabs = array_keys($pleaseShowThese);
	return View::make('test')->withTitle('Test route')->withSecctions($pleaseShowThese)->withActive(array_shift($tabs));
}));
