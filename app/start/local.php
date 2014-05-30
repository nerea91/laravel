<?php

/** THIS ONLY APPLIES TO DEVELOP (local) ENVIRONMENT */

if( ! $app->runningInConsole())
{
	// Enable SQL strict mode
	DB::statement('SET SESSION sql_mode="STRICT_ALL_TABLES"');

	// Add FirePHP Handler to Monolog
	//Log::getMonolog()->pushHandler(new \Monolog\Handler\FirePHPHandler()); //to-do enable if you use FirePHP debugger

	// Log the detected language
	Log::info(value(function () {
		$lang = App::make('language');

		return $lang .' detected from ' . $lang->detectedFrom;
	}));
}
