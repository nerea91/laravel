<?php

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showMainPage'));

//Auth area
Route::get('login', array('before' => 'guest', 'as' => 'login', 'uses' => 'AuthController@showLoginForm'));
Route::post('login', array('before' => 'guest', 'uses' => 'AuthController@doLogin'));
Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@doLogout'));

//Contact us area
Route::get('contact', array('as' => 'contact', 'uses' => 'HomeController@showContactForm'));
Route::post('contact', array('as' => 'send.contact.email', 'uses' => 'HomeController@sendContactEmail'));

//Admin area
Route::group(array('prefix' => 'admin', 'before' => ['auth', 'acl']), function() {

	Route::resource('accounts', 'AccountsController');
	Route::resource('authproviders', 'AuthProvidersController');
	Route::resource('countries', 'CountriesController');
	Route::resource('languages', 'LanguagesController');
	Route::resource('profiles', 'ProfilesController');
	Route::resource('users', 'UsersController');

});

//View composers
View::composer('layouts.base', 'BaseLayoutComposer');
