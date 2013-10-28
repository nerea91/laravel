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

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showMainPage'));

//Auth area
Route::get('login', array('before' => 'guest', 'as' => 'login', 'uses' => 'AuthController@showLoginForm'));
Route::post('login', array('before' => 'guest', 'uses' => 'AuthController@doLogin'));
Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@doLogout'));

//Contact us area
Route::get('contact', array('as' => 'contact', 'uses' => 'HomeController@showContactForm'));
Route::post('contact', array('as' => 'send.contact.email', 'uses' => 'HomeController@sendContactEmail'));

//Admin area
Route::get('admin', array('as' => 'admin', 'before' => 'auth', 'uses' => 'HomeController@showAdminPage'));//to-do añadirle un permiso en la ACL
Route::group(array('prefix' => 'admin', 'before' => ['auth', 'acl']), function() {
	Route::resource('accounts', 'AccountsController');
	Route::resource('authproviders', 'AuthProvidersController');
	Route::resource('countries', 'CountriesController');
	Route::resource('languages', 'LanguagesController');
	Route::resource('profiles', 'ProfilesController');
	Route::resource('users', 'UsersController');
});
