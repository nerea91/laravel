<?php

if ( ! $app->runningInConsole())
{
	// Enable SQL strict mode in develop environment
	DB::statement('SET SESSION sql_mode="STRICT_ALL_TABLES"');

	// Add FirePHP Handler to Monolog
	Log::getMonolog()->pushHandler(new \Monolog\Handler\FirePHPHandler());
}

