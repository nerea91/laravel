<?php

use App\Currency;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Application helpers
|--------------------------------------------------------------------------
|
| Here is where you can register all of the helper functions for
| the application.
|
*/

if ( ! function_exists('_'))
{
	/**
	 * Dummy gettext alias. Workaround until HHVM supports Gettext PHP extension.
	 *
	 * @param  string
	 * @return string
	 */
	function _($s)
	{
		return $s;
	}
}

if( ! function_exists('p'))
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
			echo \App\Debug\TVarDumper::dump($x);
		echo '</pre>';
	}
}

if( ! function_exists('ñ'))
{
	/**
	 * Dump (with colors) the passed variables and end the script.
	 *
	 * @param  dynamic mixed
	 * @return void
	 */
	function ñ()
	{
		array_map('p', func_get_args());
		die;
	}
}

if( ! function_exists('f'))
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

if( ! function_exists('replace_last_segment'))
{
	/**
	 * Replace the last segment from a route name.
	 *
	 * Assumes full stop (.) is the route segments separator.
	 *
	 * @param  string $route_name
	 * @param  string $new_segment
	 * @return string
	 */
	function replace_last_segment($route_name, $new_segment = null)
	{
		$segments = explode('.', $route_name);
		$segments = array_slice($segments, 0, count($segments) - 1);
		if( ! is_null($new_segment))
			$segments[] = $new_segment;

		return implode('.', $segments);
	}
}

if( ! function_exists('format_number'))
{
	/**
	 * Format a number with optional symbol.
	 *
	 * NOTE If decimal part is all zeros it will be trimed.
	 *
	 * @param  float  $number The number being formatted.
	 * @param  string $decimalSep Separator for the decimal point.
	 * @param  string $thousandsSep Separator for thousands.
	 * @param  string $symbol Symbol ($, €, %, ...).
	 * @param  bool   $symbolToTheRight Whether or not symbol should be place at the right.
	 * @return void
	 */
	function format_number($number, $precision = 2, $decimalSep = '.', $thousandsSep = null, $symbol = null, $symbolToTheRight = true)
	{
		// Format number
		$number = floatval(sprintf('%F', $number));
		$precision = intval($precision);
		$formatted = number_format($number, $precision, $decimalSep, $thousandsSep);

		// Trim meaningless ending zeros
		if($precision and strlen($decimalSep))
		{
			$safeDecimalSep = preg_quote($decimalSep, '/');
			$meaningless = str_repeat(0, $precision);
			$formatted = preg_replace("/{$safeDecimalSep}{$meaningless}$/", null, $formatted, 1);
		}

		// Add symbol
		if( ! strlen($symbol))
			return $formatted;

		return ($symbolToTheRight) ? "$formatted $symbol" : "$symbol $formatted";
	}
}

if( ! function_exists('number'))
{
	/**
	 * Format a number as currency but without symbol.
	 *
	 * @param  float
	 * @param  \App\Currency
	 * @param  int
	 * @return void
	 */
	function number($number, Currency $currency, $precision = 2)
	{
		return format_number($number, $precision, $currency->decimal_separator, $currency->thousands_separator);
	}
}

if( ! function_exists('percent'))
{
	/**
	 * Format a percentage as currency.
	 *
	 * @param  float
	 * @param  \App\Currency
	 * @param  int
	 * @return void
	 */
	function percent($number, Currency $currency, $precision = 2)
	{
		return format_number($number, $precision, $currency->decimal_separator, $currency->thousands_separator, '%', true);
	}
}

if( ! function_exists('currency'))
{
	/**
	 * Format a number as currency.
	 *
	 * @param  float
	 * @param  \App\Currency
	 * @param  int
	 * @return void
	 */
	function currency($number, Currency $currency, $precision = 2)
	{
		return format_number($number, $precision, $currency->decimal_separator, $currency->thousands_separator, $currency->symbol, $currency->symbol_position);
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
	 * @return array
	 */
	function add_timestamps(array $array)
	{
		$now = Carbon::now()->toDateTimeString();

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
	 * @return array
	 */
	function array_chunk_for_sqlite(array $array)
	{
		$limit = floor(999 / count(reset($array)));

		return array_chunk($array, $limit);
	}
}

if( ! function_exists('link_to_sort_by'))
{
	/**
	 * Build up links for sorting resource by column (?sortby=column)
	 *
	 * @param  array
	 * @return array
	 */
	function link_to_sort_by($labels)
	{
		$route = Route::current()->getName();
		$column = Input::get('sortby');
		$direction = Input::get('sortdir');
		$links = [];

		foreach($labels as $key => $label)
		{
			$sortby = ['sortby' => $key];
			if($key === $column and $direction !== 'desc')
				$sortby['sortdir'] = 'desc';

			$links[$key] = link_to_route($route, $label, $sortby);
		}

		return $links;
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

if( ! function_exists('week_days'))
{
	/**
	 * Return the week days using MySQL WEEKDAY() function indexing.
	 * 0 = Monday, 1 = Tuesday, ..., 6 = Sunday.
	 *
	 * @return array
	 */
	function week_days()
	{
		return [_('Monday'), _('Tuesday'), _('Wednesday'), _('Thursday'), _('Friday'), _('Saturday'), _('Sunday')];
	}
}

if( ! function_exists('week_days_odbc'))
{
	/**
	 * Return the week days using MySQL DAYOFWEEK() function indexing.
	 * These index values correspond to the ODBC standard.
	 * 1 = Sunday, 2 = Monday, ..., 7 = Saturday.
	 *
	 * @return array
	 */
	function week_days_odbc()
	{
		return [2 => _('Monday'), 3 => _('Tuesday'), 4 => _('Wednesday'), 5 => _('Thursday'), 6 => _('Friday'), 7 => _('Saturday'), 1 => _('Sunday')];
	}
}

if( ! function_exists('week_day'))
{
	/**
	 * Return the name of the provided day of the week index.
	 *
	 * @return string
	 */
	function week_day($day, $odbc = false)
	{
		$days = ($odbc) ? week_days_odbc() : week_days();

		return $days[$day];
	}
}

if( ! function_exists('markdown'))
{
	/**
	 * Convert from Markdown to HTML.
	 *
	 * @param  string
	 * @return string
	 */
	function markdown($source)
	{
		return with(new \League\CommonMark\CommonMarkConverter())->convertToHtml($source);
	}
}

// @codingStandardsIgnoreStart
/**
 * http_build_url
 * Stand alone version of http_build_url (http://php.net/manual/en/function.http-build-url.php)
 * Based on buggy and inefficient version I found at http://www.mediafire.com/?zjry3tynkg5 by tycoonmaster[at]gmail[dot]com
 * @author Chris Nasr
 * @copyright Fuel for the Fire
 * @package http (Gentoo: dev-php/pecl-http)
 * @version 0.1
 * @created 2012-07-26
 */
if( ! function_exists('http_build_url'))
{
	// Define constants
	define('HTTP_URL_REPLACE',           0x0001);    // Replace every part of the first URL when there's one of the second URL
	define('HTTP_URL_JOIN_PATH',         0x0002);    // Join relative paths
	define('HTTP_URL_JOIN_QUERY',        0x0004);    // Join query strings
	define('HTTP_URL_STRIP_USER',        0x0008);    // Strip any user authentication information
	define('HTTP_URL_STRIP_PASS',        0x0010);    // Strip any password authentication information
	define('HTTP_URL_STRIP_PORT',        0x0020);    // Strip explicit port numbers
	define('HTTP_URL_STRIP_PATH',        0x0040);    // Strip complete path
	define('HTTP_URL_STRIP_QUERY',       0x0080);    // Strip query string
	define('HTTP_URL_STRIP_FRAGMENT',    0x0100);    // Strip any fragments (#identifier)

	// Combination constants
	define('HTTP_URL_STRIP_AUTH',        HTTP_URL_STRIP_USER | HTTP_URL_STRIP_PASS);
	define('HTTP_URL_STRIP_ALL',         HTTP_URL_STRIP_AUTH | HTTP_URL_STRIP_PORT | HTTP_URL_STRIP_QUERY | HTTP_URL_STRIP_FRAGMENT);

	/**
	 * HTTP Build URL
	 * Combines arrays in the form of parse_url() into a new string based on specific options
	 * @name http_build_url
	 * @param string|array $url      The existing URL as a string or result from parse_url
	 * @param array        $parts    Same as $url
	 * @param int          $flags    URLs are combined based on these
	 * @param array        &$new_url If set, filled with array version of new url
	 * @return string
	 */
	function http_build_url(/*string|array*/ $url, /*string|array*/ $parts = array(), /*int*/ $flags = HTTP_URL_REPLACE, /*array*/ &$new_url = false)
	{
		// If the $url is a string
		if(is_string($url))
		{
			$url = parse_url($url);
		}

		// If the $parts is a string
		if(is_string($parts))
		{
			$parts    = parse_url($parts);
		}

		// Scheme and Host are always replaced
		if(isset($parts['scheme']))    $url['scheme']    = $parts['scheme'];
		if(isset($parts['host']))    $url['host']    = $parts['host'];

		// (If applicable) Replace the original URL with it's new parts
		if(HTTP_URL_REPLACE & $flags)
		{
			// Go through each possible key
			foreach(array('user','pass','port','path','query','fragment') as $key)
			{
				// If it's set in $parts, replace it in $url
				if(isset($parts[$key]))    $url[$key]    = $parts[$key];
			}
		}
		else
		{
			// Join the original URL path with the new path
			if(isset($parts['path']) && (HTTP_URL_JOIN_PATH & $flags))
			{
				if(isset($url['path']) && $url['path'] !== '')
				{
					// If the URL doesn't start with a slash, we need to merge
					if($url['path'][0] !== '/')
					{
						// If the path ends with a slash, store as is
						if('/' === $parts['path'][strlen($parts['path'])-1])
						{
							$sBasePath    = $parts['path'];
						}
						// Else trim off the file
						else
						{
							// Get just the base directory
							$sBasePath    = dirname($parts['path']);
						}

						// If it's empty
						if('' === $sBasePath)    $sBasePath    = '/';

						// Add the two together
						$url['path']    = $sBasePath . $url['path'];

						// Free memory
						unset($sBasePath);
					}

					if(false !== strpos($url['path'], './'))
					{
						// Remove any '../' and their directories
						while(preg_match('/\w+\/\.\.\//', $url['path'])) {
							$url['path']    = preg_replace('/\w+\/\.\.\//', '', $url['path']);
						}

						// Remove any './'
						$url['path']    = str_replace('./', '', $url['path']);
					}
				}
				else
				{
					$url['path']    = $parts['path'];
				}
			}

			// Join the original query string with the new query string
			if(isset($parts['query']) && (HTTP_URL_JOIN_QUERY & $flags))
			{
				if(isset($url['query']))    $url['query']    .= '&' . $parts['query'];
				else                        $url['query']    = $parts['query'];
			}
		}

		// Strips all the applicable sections of the URL
		if(HTTP_URL_STRIP_USER & $flags)        unset($url['user']);
		if(HTTP_URL_STRIP_PASS & $flags)        unset($url['pass']);
		if(HTTP_URL_STRIP_PORT & $flags)        unset($url['port']);
		if(HTTP_URL_STRIP_PATH & $flags)        unset($url['path']);
		if(HTTP_URL_STRIP_QUERY & $flags)        unset($url['query']);
		if(HTTP_URL_STRIP_FRAGMENT & $flags)    unset($url['fragment']);

		// Store the new associative array in $new_url
		$new_url    = $url;

		// Combine the new elements into a string and return it
		return
		((isset($url['scheme'])) ? $url['scheme'] . '://' : '')
		.((isset($url['user'])) ? $url['user'] . ((isset($url['pass'])) ? ':' . $url['pass'] : '') .'@' : '')
		.((isset($url['host'])) ? $url['host'] : '')
		.((isset($url['port'])) ? ':' . $url['port'] : '')
		.((isset($url['path'])) ? $url['path'] : '')
		.((isset($url['query'])) ? '?' . $url['query'] : '')
		.((isset($url['fragment'])) ? '#' . $url['fragment'] : '');
	}
}
// @codingStandardsIgnoreEnd
