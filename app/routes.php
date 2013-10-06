<?php

//Localized prefix
$prefix = Language::prefix(Request::segment(1));

Route::group(array('prefix' => $prefix), function()
{
	Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
	Route::get('test', array('as' => 'test', 'uses' => 'HomeController@index'));

	//Routes to resource controllers
	Route::resource('users', 'UsersController');
	Route::resource('posts', 'PostsController');
	Route::resource('tags', 'TagsController');
	Route::resource('countries', 'CountriesController');
	Route::resource('phones', 'PhonesController');
});
