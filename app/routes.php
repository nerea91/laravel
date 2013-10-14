<?php

if(Schema::hasTable('languages'))
{
	$language = Language::detect(Request::url());
	$language->setLocale();
	// Log::debug($language->detected_from);
}

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));


//Auth
Route::get('login', array('before' => 'gest', 'as' => 'login', 'uses' => 'AuthController@showLoginForm')); //to-do el filtro before->gest no va porque parece que estando logueado se sigue podiendo acceder a la pag de login
Route::post('login', array('before' => 'gest', 'uses' => 'AuthController@doLogin'));
Route::get('logout', array('before' => 'auth', 'as' => 'logout', 'uses' => 'AuthController@doLogout'));


Route::group(array('before' => ['auth', 'acl']), function() {

	Route::resource('accounts', 'AccountsController');
	Route::resource('authproviders', 'AuthProvidersController');
	Route::resource('profiles', 'ProfilesController');
	Route::resource('users', 'UsersController');

});






