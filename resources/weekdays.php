<?php

/** Helper functions for working with week days and MySQL or ODBC */

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
