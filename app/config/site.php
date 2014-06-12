<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Site name
	|--------------------------------------------------------------------------
	|
	| Enter the name of your site.
	| It will be appended to the <title> tag of the base the layout.
	|
	*/

	'name' => 'Test Project', //to-do

	/*
	 |--------------------------------------------------------------------------
	 | Contact email
	 |--------------------------------------------------------------------------
	 |
	 | E-mail address where the "contact us" queries will be sent to.
	 |
	 */

	'contact-email' => 'contact@example.com', //to-do

	/*
	 |--------------------------------------------------------------------------
	 | Locale category
	 |--------------------------------------------------------------------------
	 |
	 | A named constant specifying the category of the functions affected by
	 | the locale setting. Possible values:
	 |
	 | LC_COLLATE for string comparison, see strcoll().
	 | LC_CTYPE for character classification and conversion, for example strtoupper().
	 | LC_MONETARY for localeconv().
	 | LC_NUMERIC for decimal separator (See also localeconv()).
	 | LC_TIME for date and time formatting with strftime().
	 | LC_MESSAGES for system responses (available if PHP was compiled with libintl).
	 | LC_ALL for all of the below.
	 |
	 | NOTE: LC_ALL may switch float decimal separator character deppending on locale.
	 | This could cause undesired issues specially when inserting float values to your
	 | data base. If that is your case consider using LC_MESSAGES instead.
	 |
	 */

	'locale-category' => LC_ALL,

);
