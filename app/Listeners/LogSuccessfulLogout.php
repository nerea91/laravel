<?php

namespace App\Listeners;

use App\Language;
use Cache;

use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
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
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        // Access the user using $event->user...
        // Reset default application language
		Language::forget();

		// Purge admin panel search results cache
		Cache::forget('adminSearchResults' . $event->user->getKey());
    }
}