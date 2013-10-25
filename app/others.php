<?php

/*
|--------------------------------------------------------------------------
| Application Extensions
|--------------------------------------------------------------------------
|
| Here is where you can add all the snippets that your application needs
| other than routes or filters (i.e: view composers, auth drivers, custom
| validation rules, etc ...).
|
*/

//View composers
View::composer('layouts.base', 'BaseLayoutComposer');
