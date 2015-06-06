<?php

/** Helper functions for formating currency values */

if( ! function_exists('format_number'))
{
	/**
	 * Format a number with optional symbol.
	 *
	 * NOTE If decimal part is all zeros it will be trimed.
	 *
	 * @param  float  $number           The number being formatted.
	 * @param  string $decimalSep       Separator for the decimal point.
	 * @param  string $thousandsSep     Separator for thousands.
	 * @param  string $symbol           Symbol ($, €, %, ...).
	 * @param  bool   $symbolToTheRight Whether or not symbol should be place at the right.
	 *
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
	 *
	 * @return void
	 */
	function number($number, App\Currency $currency, $precision = 2)
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
	 *
	 * @return void
	 */
	function percent($number, App\Currency $currency, $precision = 2)
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
	 *
	 * @return void
	 */
	function currency($number, App\Currency $currency, $precision = 2)
	{
		return format_number($number, $precision, $currency->decimal_separator, $currency->thousands_separator, $currency->symbol, $currency->symbol_position);
	}
}
