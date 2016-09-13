<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Access the user using $event->user...
        
        // Change application language to current user's language
		$event->user->applyLanguage();
       
    }
}
