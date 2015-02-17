<?php

/*
 * Laravel doesn't allow to send a plain text email without using a view.
 *
 * So here it is the view. To use it:
 *
 * Mail::send(array('text' => 'emails.plain-text'), ['text' => 'Your plain text'], function($message)
 * {
 *   $message->to('foo@example.com', 'John Smith')->subject('Welcome!');
 * });
 *
 */

echo $text;
