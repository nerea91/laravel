<?php

if( ! $app->runningInConsole())
{
	// Enable SQL strict mode in develop environment
	DB::statement('SET SESSION sql_mode="STRICT_ALL_TABLES"');

	// Add FirePHP Handler to Monolog
	//Log::getMonolog()->pushHandler(new \Monolog\Handler\FirePHPHandler()); //to-do enable if you ise FirePHP debugger

	// Log the detected language
	Log::info(value(function () {
		$lang = App::make('language');
		return $lang .' detected from ' . $lang->detectedFrom;
	}));
}
