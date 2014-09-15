<?php namespace App\Composers;

use Auth;
use Stolz\Menu\Nodes\Flat;
use Stolz\Menu\Nodes\Link;
use Stolz\Menu\Nodes\Node;
use Stolz\Menu\Renders\FoundationTopBar;

class ReportsMenuComposer
{
	public function compose($view)
	{
		// Build menu tree for the top bar
		$menu = new Node('menu', [
			self::buildTree()->addChild(AdminPanelMenuComposer::buildTree()),
			AdminPanelMenuComposer::buildSecondaryTree()
		]);

		// Pass menu to the view
		$view->with('menu', $menu->setRender(new FoundationTopBar())->purge());
	}

	/**
	 * Build the main tree.
	 *
	 * @return Menu\Node
	 */
	public static function buildTree()
	{
		extract(self::makeSections(Auth::user()));

		return new Node(_('Reports'), [
			$sampleReport,
		]);
	}

	/**
	 * Define the main sections of the menu.
	 *
	 * @param  User $user User to checked permissions against
	 * @return array (of Menu\Node)
	 */
	public static function makeSections(User $user)
	{
		$sampleReport = (App::environment('local')) ? new Link(route('report.sample'), with(new SampleReport)->title()) : new Node();

		return compact('sampleReport');
	}
}
