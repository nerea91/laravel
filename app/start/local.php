<?php

//Enable SQL strict mode in develop environment
if ( ! $app->runningInConsole())
	DB::statement('SET SESSION sql_mode="STRICT_ALL_TABLES"');

