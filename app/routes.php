<?php

$language = Language::detect(Request::url());
$language->setLocale();
// Log::debug($language->detected_from);

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::resource('users', 'UsersController');
Route::resource('posts', 'PostsController');
Route::resource('tags', 'TagsController');
Route::resource('countries', 'CountriesController');
Route::resource('phones', 'PhonesController');

