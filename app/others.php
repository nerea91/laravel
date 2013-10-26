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

//View composers
View::composer('layouts.base', 'BaseLayoutComposer');

//Helpers
if ( ! function_exists('d'))
{
	/**
	 * Dump the passed variables and end the script.
	 *
	 * @param  dynamic  mixed
	 * @return void
	 */
	function d()
	{
		echo '<pre>';
		array_map(function($x) { print_r($x); }, func_get_args());
		echo '</pre>';
		die;
	}
}
