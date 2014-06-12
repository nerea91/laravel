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

View::composer(['layouts.base', 'layouts.admin'], 'BaseLayoutComposer');

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

/**
 * Create a group of checkboxes.
 *
 * @param  string  $name
 * @param  array   $values
 * @param  array   $checked
 * @param  array   $options
 * @return string
 */
Form::macro('checkboxes', function ($name, $values, $checked = array(), $options = array()) {
	return Form::checkables('checkbox', $name, $values, $checked, $options);
});

/**
 * Create a group of radio buttons.
 *
 * @param  string  $name
 * @param  array   $values
 * @param  array   $checked
 * @param  array   $options
 * @return string
 */
Form::macro('radios', function ($name, $values, $checked = array(), $options = array()) {
	return Form::checkables('radio', $name, $values, $checked, $options);
});

/**
 * Create a group of checkable input fields.
 *
 * $options[
 * 	'legend' => 'txt', // to get a fieldset with legend
 * 	'small'  => 1,     // Number of grid columns for small screens
 * 	'medium' => 2,     // Number of grid columns for medium screens
 * 	'large'  => 3,     // Number of grid columns for large screens
 * ]
 *
 * @param  string  $type
 * @param  string  $name
 * @param  array   $values
 * @param  array   $checked
 * @param  array   $options
 * @return string
 */

Form::macro('checkables', function ($type, $name, $values, $checked, $options) {
	// Unset options that should not to be passed to Form::*
	$legend = (isset($options['legend'])) ? $options['legend'] : false;
	$small = (isset($options['small'])) ? $options['small'] : 2;
	$medium = (isset($options['medium'])) ? $options['medium'] : 3;
	$large = (isset($options['large'])) ? $options['large'] : 4;
	unset($options['legend'], $options['small'], $options['medium'], $options['large']);

	$out = ($legend) ? '<fieldset class="checkables"><legend>' . $legend . '</legend>' : null;
	if($legend and $type == 'checkbox')
		$out .= '
		<div class="checkbox_togglers">
			<a href="all">'._('all').'</a> &#8226;
			<a href="none">'._('none').'</a> &#8226;
			<a href="invert">'._('invert').'</a>
		</div>';

	$out .= "<ul class=\"small-block-grid-$small medium-block-grid-$medium large-block-grid-$large\">";

	foreach($values as $value => $label)
	{
		$options['id'] = $id = $name . $value;
		$check = in_array($value, $checked);

		$out .= '<li><label for="' . $id . '" style="display:inline">';
		$out .= ($type == 'radio') ? Form::radio($name, $value, $check, $options) : Form::checkbox($name.'[]', $value, $check, $options);
		$out .= '&nbsp;'.$label;
		$out .= '</label></li>';
	}

	$out .= '</ul>';

	if($legend)
		$out .= '</fieldset>';

	return $out;
});
