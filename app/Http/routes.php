<?php

// Home page
get('/', ['as' => 'home', 'uses' => 'HomeController@showMainPage']);

// Change application language
get('language/{code}', ['as' => 'language.set', function ($code) {
	if($language = App\Language::whereCode($code)->first())
		$language->remember();

	return redirect(URL::previous() ?: route('home'));
}])->where('code', '^[a-z][a-z]$');

// Contact us area
get('contact', ['as' => 'contact', 'uses' => 'HomeController@showContactForm']);
post('contact', ['as' => 'contact.send', 'uses' => 'HomeController@sendContactEmail']);

// Log viewer. Permissions are handled by the controller
get('logs', 'LogViewerController@showLogs');

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
		get('accounts', ['as' => 'user.accounts', 'uses' => 'UserPanelController@showAccountsForm']);
		put('accounts', ['as' => 'user.accounts.update', 'uses' => 'UserPanelController@updateAccounts']);
	});

	// Admin area
	Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
		get('/', ['as' => 'admin', 'uses' => 'AdminController@showAdminPage']);
		post('/', ['as' => 'admin.search', 'uses' => 'AdminController@search']);

		// Resource controllers require ACL
		Route::group(['middleware' => 'acl'], function () {

			$resources = [
				'accounts'      => 'AccountsController',
				'authproviders' => 'AuthProvidersController',
				'countries'     => 'CountriesController',
				'currencies'    => 'CurrenciesController',
				'documents'     => 'DocumentsController',
				'languages'     => 'LanguagesController',
				'profiles'      => 'ProfilesController',
				'users'         => 'UsersController',
				#_RESOURCE_GENERATOR_MARKER_#_DO_NOT_REMOVE_#
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
			#_REPORT_GENERATOR_MARKER_#_DO_NOT_REMOVE_#
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

// Test routes (available only on local environment)
Route::group(['prefix' => 'test', 'middleware' => 'env:local'], function () {

	// General purpose
	get('/', function () {
		return ['time' => time()];
	});

	// Zurb Foundation
	get('foundation', function () {
		$title = 'Foundation';
		$colors = ['white', 'ghost', 'snow', 'vapor', 'white-smoke', 'silver', 'smoke', 'gainsboro', 'iron', 'base', 'aluminum', 'jumbo', 'monsoon', 'steel', 'charcoal', 'tuatara', 'oil', 'jet', 'black', 'primary-color', 'secondary-color', 'alert-color', 'success-color', 'warning-color', 'info-color'];

		return view('foundation/index', compact('title', 'colors'));
	});

});
