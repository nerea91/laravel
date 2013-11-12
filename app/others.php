<?php

/*
|--------------------------------------------------------------------------
| Application Extensions
|--------------------------------------------------------------------------
|
| Here is where you can add all the snippets that your application needs
| other than routes or filters (i.e: view composers, auth drivers, custom
| validation rules, etc ...).
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
| Validation
|--------------------------------------------------------------------------
*/

Validator::resolver(function($translator, $data, $rules, $messages)
{
	return new \Stolz\Validation\Validator($translator, $data, $rules, $messages);
});


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

if ( ! function_exists('p'))
{
	/**
	 * Dump (with colors) the passed variables.
	 *
	 * @param  dynamic mixed
	 * @return string
	 */
	function p()
	{
		echo '<pre>';
		foreach(func_get_args() as $x)
			echo TVarDumper::dump($x);
		echo '</pre>';
	}
}

if ( ! function_exists('d'))
{
	/**
	 * Dump (with colors) the passed variables and end the script.
	 *
	 * @param  dynamic mixed
	 * @return void
	 */
	function d()
	{
		array_map('p', func_get_args());
		die;
	}
}

if ( ! function_exists('f'))
{
	/**
	 * Log the passed variable to FirePHP
	 *
	 * @param  mixed $value
	 * @param  string $label
	 * @return void
	 */
	function f($value, $label = null)
	{
		(new FirePHP)->log($value, $label);
	}
}

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
