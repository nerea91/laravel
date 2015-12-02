<?php

// This file is supposed to be loaded by composer.json

require_once __DIR__ . '/currency.php';
require_once __DIR__ . '/html.php';
require_once __DIR__ . '/missing.php';
require_once __DIR__ . '/weekdays.php';

if( ! function_exists('replace_last_segment'))
{
	/**
	 * Replace the last segment from a route name.
	 *
	 * Assumes full stop (.) is the route segments separator.
	 *
	 * @param  string $routeName
	 * @param  string $newSegment
	 *
	 * @return string
	 */
	function replace_last_segment($routeName, $newSegment = null)
	{
		$segments = explode('.', $routeName);
		$segments = array_slice($segments, 0, count($segments) - 1);
		if( ! is_null($newSegment))
			$segments[] = $newSegment;

		return implode('.', $segments);
	}
}

if( ! function_exists('enum'))
{
	/**
	 * Implode an $array using 'and' as the last $glue.
	 *
	 * i.e: enum(['one','two','three']) will return 'one, two and three'
	 *
	 * @param array
	 * @param string
	 *
	 * @return string
	 */
	function enum(array $array, $glue = ', ')
	{
		$last = array_pop($array);

		if( ! $array)
			return $last;

		return sprintf(_('%s and %s'), implode($array, $glue), $last);
	}
}

if( ! function_exists('add_timestamps'))
{
	/**
	 * Adds 'created_at' and 'updated_at' keys to all elements of $array.
	 *
	 * @param  array $array of arrays
	 *
	 * @return array
	 */
	function add_timestamps(array $array)
	{
		$now = Carbon\Carbon::now()->toDateTimeString();

		return array_map(function ($row) use ($now) {
			$row['updated_at'] = $row['created_at'] = $now;

			return $row;

		}, $array);
	}
}

if( ! function_exists('array_chunk_for_sqlite'))
{
	/**
	 * Split an $array into chunks whose size does not exceed the SQLite batch insert limits.
	 *
	 * http://www.sqlite.org/limits.html
	 *
	 * @param  array $array of arrays
	 *
	 * @return array
	 */
	function array_chunk_for_sqlite(array $array)
	{
		$limit = floor(999 / count(reset($array)));

		return array_chunk($array, $limit);
	}
}

if( ! function_exists('numerize'))
{
	/**
	 * Converts a literal representing a number to the most appropiated numeric format (integer or float).
	 *
	 * If the literal does not represent a number it is returned unaltered.
	 *
	 * i.e:
	 *
	 *  "foo" => "foo" (string)
	 *  "1.2" => 1.2   (float)
	 *    1.2 => 1.2   (float)
	 *    "1" => 1     (integer)
	 *      1 => 1     (integer)
	 *
	 * @param  mixed
	 *
	 * @return mixed
	 */
	function numerize($literal)
	{
		return (is_numeric($literal)) ? "$literal" + 0 : $literal;
	}
}

if( ! function_exists('generate_username'))
{
	/**
	 * Generate a valid username that is not already in use.
	 *
	 * If any arguments are passed they will be used it base for the username.
	 *
	 * @param  mixed  $tryWith
	 * @return string
	 */
	function generate_username($tryWith = null)
	{
		$usernames = is_array($tryWith) ? $tryWith : func_get_args();
		$username = array_shift($usernames);

		// If no username provided generate a random one
		if(empty($username))
			$username = 'user' . str_random(rand(5, 8));
		else
		{
			// Trim non alphanumeric characters
			$username = preg_replace('/[^\da-z]/i', null, $username);

			// Trim numbers from the begining
			$username = preg_replace('/^\d+/', null, $username);

			// Ensure at least 4 characters length
			if(strlen($username) < 4)
				return generate_username($usernames);

			// Truncate and lower case
			$username = strtolower(substr($username, 0, 32));
		}

		if(is_null(DB::table('users')->whereUsername($username)->first()))
			return $username;

		return generate_username($usernames);
	}
}

if( ! function_exists('escape_sql'))
{
	/**
	 * Escapes special characters in a $string for use in an SQL statement
	 * and optionaly wraps the $string with a $prefix and a $postfix.
	 *
	 * @param  string
	 * @param  string
	 * @param  string
	 * @return string
	 */
	function escape_sql($string, $prefix = '', $postfix = '')
	{
		// Remove special chars
		$string = str_replace(["\0", "'", '"', "\b", "\n", "\r", "\t", "\Z", "\\", '%', '_', ';', '?'], '', $string);
		$string = trim($string);

		return \DB::connection()->getPdo()->quote($prefix . $string . $postfix);
	}
}
