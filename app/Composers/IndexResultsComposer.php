<?php namespace App\Composers;

use Assets;

class IndexResultsComposer
{
	public function compose($view)
	{
		Assets::add(['admin', 'responsive-tables']);
	}
}
