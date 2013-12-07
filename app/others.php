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

View::composer('layouts.base', 'BaseLayoutComposer');

/*
|--------------------------------------------------------------------------
| Event listentener
|--------------------------------------------------------------------------
*/

Event::listen('account.login', function($account)
{
	// Update IP address
	$account->last_ip = Request::getClientIp();
	$account->save();

	// Increment login count for the account ...
	$account->increment('login_count');

	// ... and for its auth provider
	$account->provider()->increment('login_count');
});

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

Validator::resolver(function($translator, $data, $rules, $messages)
{
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
Form::macro('checkboxes', function ($name, $values, $checked = array(), $options = array())
{
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
Form::macro('radios', function ($name, $values, $checked = array(), $options = array())
{
	return Form::checkables('radio', $name, $values, $checked, $options);
});

/**
 * Create a group of checkable input fields.
 *
 * @param  string  $type
 * @param  string  $name
 * @param  array   $values
 * @param  array   $checked
 * @param  array   $options Use $options['legend'] to get a fieldset with legend
 * @return string
 */

Form::macro('checkables', function($type, $name, $values, $checked, $options)
{
	$legend = (isset($options['legend'])) ? $options['legend'] : false;
	unset($options['legend']);

	$out = ($legend) ? "<fieldset><legend>$legend</legend>" : null;
	$out .= '<ul class="small-block-grid-2 large-block-grid-4">';

	foreach($values as $value => $label)
	{
		$options['id'] = $id = $name . $value;
		$check = in_array($value, $checked);

		$out .= '<li><label for="' . $id . '" style="display:inline">';
		$out .= ($type == 'radio') ? Form::radio($name.'[]', $value, $check, $options) : Form::checkbox($name.'[]', $value, $check, $options);
		$out .= '&nbsp;'.$label;
		$out .= '</label></li>';
	}

	$out .= '</ul>';

	if($legend)
		$out .= '</fieldset>';

	return $out;
});
