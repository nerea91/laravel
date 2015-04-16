<?php

use App\Language;

// Home page
get('/', ['as' => 'home', 'uses' => 'HomeController@showMainPage']);

// Change application language
get('language/{code}', ['as' => 'language.set', function ($code) {
	if($language = Language::whereCode($code)->first())
		$language->remember();

	return redirect(URL::previous() ?: route('home'));
}])->where('code', '^[a-z][a-z]$');

// Contact us area
get('contact', ['as' => 'contact', 'uses' => 'HomeController@showContactForm']);
post('contact', ['as' => 'contact.send', 'uses' => 'HomeController@sendContactEmail']);

// Guest user area
Route::group(['https', 'middleware' => 'guest', 'prefix' => 'login'], function () {

	// Login with native authentication
	get('/', ['as' => 'login', 'uses' => 'AuthController@showLoginForm']);
	post('/', ['as' => 'login.send', 'uses' => 'AuthController@login']);

	// Login with an Oauth provider
	get('with/{provider}', ['as' => 'login.oauth', 'uses' => 'AuthController@oauthLogin']);

});

// Authenticated user area
Route::group(['https', 'middleware' => 'auth'], function () {

	get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

	// Current user control panel
	Route::group(['prefix' => 'user'], function () {
		get('options', ['as' => 'user.options', 'uses' => 'UserPanelController@showOptionsForm']);
		put('options', ['as' => 'user.options.update', 'uses' => 'UserPanelController@updateOptions']);
		get('password', ['as' => 'user.password', 'uses' => 'UserPanelController@showChangePasswordForm']);
		put('password', ['as' => 'user.password.update', 'uses' => 'UserPanelController@updatePassword']);
		get('regional', ['as' => 'user.regional', 'uses' => 'UserPanelController@showRegionalForm']);
		put('regional', ['as' => 'user.regional.update', 'uses' => 'UserPanelController@updateRegional']);
	});

	// Admin area
	Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
		get('/', ['as' => 'admin', 'uses' => 'AdminController@showAdminPage']);
		post('/', ['as' => 'admin.search', 'uses' => 'AdminController@search']);

		// Resource controllers require ACL
		Route::group(['middleware' => 'acl'], function () {

			$resources = [
				'accounts' => 'AccountsController',
				'authproviders' => 'AuthProvidersController',
				'countries' => 'CountriesController',
				'currencies' => 'CurrenciesController',
				'documents' => 'DocumentsController',
				'languages' => 'LanguagesController',
				'profiles' => 'ProfilesController',
				'users' => 'UsersController',
			];

			foreach($resources as $name => $controller)
			{
				Route::resource($name, $controller);
				put("$name/{id}/restore", ['as' => "admin.$name.restore", 'uses' => "$controller@restore"]);
				get("$name/trash/{mode}", ['as' => "admin.$name.trash.mode", 'uses' => "$controller@setTrashMode"]);
			}
		});

	});

	// Reports area
	Route::group(['prefix' => 'report', 'middleware' => 'acl', 'namespace' => 'Reports'], function () {

		$reports = [
			'sample' => 'SampleReport',
		];

		foreach($reports as $name => $controller)
		{
			$url = str_replace('.', '/', $name);
			get($url, ['as' => "report.$name", 'uses' => "$controller@show"]);
			post($url, ['as' => "report.$name.validate", 'uses' => "$controller@validate"]);
		}

	});

	// Documents area
	get('document/{id}/{title?}', ['as' => 'document', 'uses' => 'DocumentController@show']);

});

// Route for testings purposes, only available on local environment
get('test', ['as' => 'test', 'middleware' => 'acl', function () {

	dd(1, 2, 3);
}]);
