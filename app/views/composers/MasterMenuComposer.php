<?php

use Stolz\Menu\Nodes\Flat;
use Stolz\Menu\Nodes\Link;
use Stolz\Menu\Nodes\Node;

class MasterMenuComposer
{
	public function compose($view)
	{
		// Root of the navigation menu
		$menu = new Node('root', [
			//to-do
		]);

		// Pass menu to view
		$view->with('menu', $menu);
	}
}
