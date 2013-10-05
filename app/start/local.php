<?php

//Enable SQL strict mode in develop environment
if(php_sapi_name() != 'cli')
	DB::statement('SET SESSION sql_mode="STRICT_ALL_TABLES"');

