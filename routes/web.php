<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Home page
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@showMainPage']);

Route::get('welcome', ['as' => 'welcome', function(){
	return view('welcome');
}]);

// Change application language
Route::get('language/{code}', ['as' => 'language.set', function ($code) {
	if($language = App\Language::whereCode($code)->first())
		$language->remember();

	return redirect(URL::previous() ?: route('home'));
}])->where('code', '^[a-z][a-z]$');

// Contact us area
Route::get('contact', ['as' => 'contact', 'uses' => 'HomeController@showContactForm']);
Route::post('contact', ['as' => 'contact.send', 'uses' => 'HomeController@sendContactEmail']);

// Log viewer. Permissions are handled by the controller
Route::get('logs', 'LogViewerController@showLogs');

// Guest user area
Route::group(['https', 'middleware' => ['guest', 'force_https_url_scheme'], 'prefix' => 'login'], function () {

	// Login with native authentication
	Route::get('/', ['as' => 'login', 'uses' => 'AuthController@showLoginForm']);
	Route::post('/', ['as' => 'login.send', 'uses' => 'AuthController@login']);

	// Login with an Oauth provider
	Route::get('with/{provider}', ['as' => 'login.oauth', 'uses' => 'AuthController@oauthLogin']);

});

// Authenticated user area
Route::group(['https', 'middleware' => ['auth', 'force_https_url_scheme']], function () {

	Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

	// Current user control panel
	Route::group(['prefix' => 'user'], function () {
		Route::get('options', ['as' => 'user.options', 'uses' => 'UserPanelController@showOptionsForm']);
		Route::put('options', ['as' => 'user.options.update', 'uses' => 'UserPanelController@updateOptions']);
		Route::get('password', ['as' => 'user.password', 'uses' => 'UserPanelController@showChangePasswordForm']);
		Route::put('password', ['as' => 'user.password.update', 'uses' => 'UserPanelController@updatePassword']);
		Route::get('regional', ['as' => 'user.regional', 'uses' => 'UserPanelController@showRegionalForm']);
		Route::put('regional', ['as' => 'user.regional.update', 'uses' => 'UserPanelController@updateRegional']);
		Route::get('accounts', ['as' => 'user.accounts', 'uses' => 'UserPanelController@showAccountsForm']);
		Route::put('accounts', ['as' => 'user.accounts.update', 'uses' => 'UserPanelController@updateAccounts']);
	});

	// Admin area
	Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
		Route::get('/', ['as' => 'admin', 'uses' => 'AdminController@showAdminPage']);
		Route::post('/', ['as' => 'admin.search', 'uses' => 'AdminController@search']);

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
				Route::resource($name, $controller, ['names' => [
                    'index' => 'admin.'.$name.'.index',
                    'create' => 'admin.'.$name.'.create',
					'edit' => 'admin.'.$name.'.edit',
                    'show' => 'admin.'.$name.'.show',
					'store' => 'admin.'.$name.'.store',
					'update' => 'admin.'.$name.'.update',
					'destroy' => 'admin.'.$name.'.destroy',
                ]]);
				Route::put("$name/{id}/restore", ['as' => "admin.$name.restore", 'uses' => "$controller@restore"]);
				Route::get("$name/trash/{mode}", ['as' => "admin.$name.trash.mode", 'uses' => "$controller@setTrashMode"]);
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
			Route::get($url, ['as' => "report.$name", 'uses' => "$controller@show"]);
			Route::post($url, ['as' => "report.$name.validate", 'uses' => "$controller@validate"]);
		}

	});

	// Documents area
	Route::get('document/{id}/{title?}', ['as' => 'document', 'uses' => 'DocumentController@show']);

});

// Test routes (available only on local environment)
Route::group(['prefix' => 'test', 'middleware' => 'env:local'], function () {

	// General purpose
	Route::get('/', function () {
		return ['time' => time()];
	});

	// Zurb Foundation
	Route::get('foundation', function () {
		$title = 'Foundation';
		$colors = ['white', 'ghost', 'snow', 'vapor', 'white-smoke', 'silver', 'smoke', 'gainsboro', 'iron', 'base', 'aluminum', 'jumbo', 'monsoon', 'steel', 'charcoal', 'tuatara', 'oil', 'jet', 'black', 'primary-color', 'secondary-color', 'alert-color', 'success-color', 'warning-color', 'info-color'];

		return view('foundation/index', compact('title', 'colors'));
	});

});
