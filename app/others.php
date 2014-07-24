<?php

/*
|--------------------------------------------------------------------------
| Application Extensions
|--------------------------------------------------------------------------
|
| Here is where you can add all the snippets that your application needs
| other than routes, filters or helpers  (i.e: view composers, auth drivers,
| custom validation rules, etc ...).
|
*/

/*
|--------------------------------------------------------------------------
| View composers
|--------------------------------------------------------------------------
*/

View::composers([
	// View composer class => View file (use an array for more than one)
	'AdminTopBarComposer' => 'admin/top-bar',
	'DebugBarComposer' => 'layouts.base',
	'LocaleComposer' => ['layouts.base', 'layouts.master'],
	'MasterMenuComposer' => 'layouts.master'
]);

/*
|--------------------------------------------------------------------------
| Event listentener
|--------------------------------------------------------------------------
*/

Event::listen('account.login', function ($account) {
	// Update IP address
	$account->last_ip = Request::getClientIp();
	$account->save();

	// Increment login count for the account ...
	$account->increment('login_count');

	// ... and for its auth provider
	$account->provider()->increment('login_count');
});

Event::listen('auth.login', function ($user) {
	// Change application language to current user's language
	$user->applyLanguage();
});

Event::listen('auth.logout', function ($user) {
	// Reset default application language
	Language::forget();

	// Purge admin panel search results cache
	Cache::forget('adminSearchResults' . $user->getKey());
});

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

Validator::resolver(function ($translator, $data, $rules, $messages) {
	return new \Stolz\Validation\Validator($translator, $data, $rules, $messages);
});

/*
|--------------------------------------------------------------------------
| Form macros
|--------------------------------------------------------------------------
*/
