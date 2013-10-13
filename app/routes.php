<?php

if(Schema::hasTable('languages'))
{
	$language = Language::detect(Request::url());
	$language->setLocale();
	// Log::debug($language->detected_from);
}

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::group(array('before' => 'auth'), function() {

	Route::resource('authproviders', 'AuthProvidersController');
	Route::resource('profiles', 'ProfilesController');
	Route::resource('users', 'UsersController');

});




