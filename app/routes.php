<?php

/*
|--------------------------------------------------------------------------
| Set global locale
|--------------------------------------------------------------------------
|
| When no locale is used, the default locale is used and no prefix is set, so you have links like /news and /about.
| But when you access /es, the links will be /es/news and /es/about.
|
| If you prefer the default locale to be always prefixed in the route then add it to the $languages array and redirect to the default, when no | | | | language is set
|
| This way, you can just use URL::route('home') or URL::action('SomeController@showMethod') and the locale will be prefixed.
|
*/

$languages = array('es','fr');
$locale = Request::segment(1);

if(in_array($locale, $languages)){
	App::setLocale($locale);
	//to-do call gettext here
}else{
	$locale = null;
}


Route::group(array('prefix' => $locale), function()
{
	Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
	Route::get('/test', array('as' => 'test', 'uses' => 'HomeController@index'));

	Route::resource('users', 'UsersController');
	Route::resource('posts', 'PostsController');
	Route::resource('tags', 'TagsController');
	Route::resource('countries', 'CountriesController');
	Route::resource('phones', 'PhonesController');
});
