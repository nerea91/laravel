<?php

return array(

	/*
	 |--------------------------------------------------------------------------
	 | Base command to run schemaSpy.jar on your system
	 |--------------------------------------------------------------------------
	 |
	 | No parametes here, instead use 'arguments' array below!
	 |
	 | Default: java -jar schemaSpy.jar
	 |
	 */

	'command' => 'java -jar /home/stolz/git/java-schema-spy/schemaSpy_5.0.0.jar',

	/*
	 |--------------------------------------------------------------------------
	 | Directory where generated files will be written
	 |--------------------------------------------------------------------------
	 |
	 | Default: app_path('database/schema')
	 |
	 */

	'output' => base_path('database/schema'),

	/*
	|--------------------------------------------------------------------------
	| Extra parametes to pass to the command
	|--------------------------------------------------------------------------
	|
	| Database connection settings will be read form Laravel database config so
	| there is no need to specify them here unless you want to override them.
	|
	| Full list of possible arguments: http://schemaspy.sourceforge.net/
	|
	*/

	'parameters' => [
		'-t'  => 'mysql',
		'-dp' => '/home/stolz/git/java-schema-spy/mysql-connector-java-5.1.30-bin.jar',
		'-hq' => null,
	],

);
