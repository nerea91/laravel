<?php namespace App\Composers;

use Assets;
use Cache;
use Carbon\Carbon;
use File;

class DebugBarComposer
{
	public function compose($view)
	{
		// Add debugbar if it's enabled
		if(app()->bound('debugbar') and config('laravel-debugbar::config.enabled', false))
		{
			Assets::add('debugbar');
			$renderer = app('debugbar')->getJavascriptRenderer();

			// Dinamically generate DebugBar assets every 7 days
			$lastTimeAssetsWereGenerated = Cache::remember('debugbar', 60 * 24 * 7, function() use ($renderer) {
				File::put(public_path('css/debugbar.css'), $renderer->dumpAssetsToString('css') . 'div.phpdebugbar ul,div.phpdebugbar ol,div.phpdebugbar dl {font-size: 100%;}');
				File::put(public_path('js/debugbar.js'), $renderer->dumpAssetsToString('js'));
				return Carbon::now()->toDateString();
			});

			$view->with('debugbar', $renderer->render());
		}
	}
}
