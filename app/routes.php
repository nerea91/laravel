<?php

if(Schema::hasTable('languages'))
{
	$language = Language::detect(Request::url());
	$language->setLocale();
	// Log::debug($language->detected_from);
}

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));


Route::get('login', array('before' => 'guest', 'as' => 'login', 'uses' => 'AuthController@showLoginForm'));
Route::post('login', array('before' => 'guest', 'uses' => 'AuthController@doLogin'));
Route::get('logout', array('before' => 'auth', 'as' => 'logout', 'uses' => 'AuthController@doLogout'));


Route::group(array('before' => ['auth', 'acl']), function() {

	Route::resource('accounts', 'AccountsController');
	Route::resource('authproviders', 'AuthProvidersController');
	Route::resource('countries', 'CountriesController');
	Route::resource('profiles', 'ProfilesController');
	Route::resource('users', 'UsersController');

});








