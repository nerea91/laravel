<?php

/*
|--------------------------------------------------------------------------
| HTML Tidy
|--------------------------------------------------------------------------
|
| Project: http://tidy.sourceforge.net
| PHP extension: http://php.net/manual/en/book.tidy.php
|
*/
return array(

	// Disabled for production
	'enabled' => false,

	// Encoding of your documents. Possible values: ascii, latin0, latin1, raw, utf8, iso2022, mac, win1252, ibm858, utf16, utf16le, utf16be, big5, and shiftjis.
	'encoding' => 'utf8',

	// Doctype used for the output
	'doctype' => '<!DOCTYPE html>',

	// Append errors to output
	'display_errors' => true,

	// Errors container open tag
	'open' => '<div id="tidy_errors" style="position: absolute;right: 0;top: 0;z-index: 100;padding:1em;margin:1em;border:1px solid #DC0024;font-family: Sans-Serif;background-color:#FFE5E5;color:#DC0024"><a style="float:right;cursor:pointer;color:blue;margin:-15px" onclick="document.getElementById(\'tidy_errors\').style.display = \'none\'">[x]</a>',

	// Errors container close tag
	'close' => '</div>',

	// Options passed to parseString() function
	'options' => array(
		'output-xhtml' => true,
		'char-encoding' => 'utf8',
		//'hide-comments' => true,
		'wrap' => 0,
		'wrap-sections' => false,
		'indent' => 2, // 2 is equivalent to 'auto', which seems to be ignored by PHP-html-tidy extension
		'indent-spaces' => 4,

		// HTML5 workarounds
		'doctype' => 'omit', //The filter will add the configured doctype later
		'new-blocklevel-tags' =>  'article,aside,canvas,dialog,embed,figcaption,figure,footer,header,hgroup,nav,output,progress,section,video',
		'new-inline-tags' => 'audio,bdi,command,datagrid,datalist,details,keygen,mark,meter,rp,rt,ruby,source,summary,time,track,wbr',
	),

	// Errors that match these regexs will be filtered out
	'filter' => array(
		// workaround to hide errors related to HTML5
		"/line.*proprietary attribute \"data-.*\n?/",
		"/line.*proprietary attribute \"placeholder.*\n?/",
		"/line.*proprietary attribute \"autofocus.*\n?/",
		"/line.*is not approved by W3C\n?/",
		"/line.*<html> proprietary attribute \"class\"\n?/",
		"/line.*<meta> proprietary attribute \"charset\"\n?/",
		"/line.*<meta> lacks \"content\" attribute\n?/",
		"/line.*<table> lacks \"summary\" attribute\n?/",
		"/line.*<style> inserting \"type\" attribute\n?/",
		"/line.*<script> inserting \"type\" attribute\n?/",
		// CSS frameworks use a lot of empty tags for navigation/pagination
		"/line.*trimming empty <li>\n?/",
		"/line.*trimming empty <span>\n?/",
	),

);
