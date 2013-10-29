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
if ( ! function_exists('p'))
{
	/**
	 * Print the passed variables and end the script.
	 *
	 * @param  dynamic  mixed
	 * @return string
	 */
	function p()
	{
		echo '<pre>';
		array_map(function($x) { print_r($x); }, func_get_args());
		echo '</pre>';
		die;
	}
}

if ( ! function_exists('d'))
{
	/**
	 * Log the passed to FirePHP
	 *
	 * @param  dynamic  mixed
	 * @return voir
	 */
	function d()
	{
		$firephp = new FirePHP;
		array_map(function($x) use ($firephp) { $firephp->log($x); }, func_get_args());
	}
}

