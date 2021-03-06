<?php namespace App\Composers;

use App\User;
use Stolz\Menu\Nodes\Flat;
use Stolz\Menu\Nodes\Link;
use Stolz\Menu\Nodes\Node;
use App\Renders\FoundationTopBar;

class ReportsMenuComposer
{
	public function compose($view)
	{
		\Assets::add(['admin', 'offcanvas', 'datepicker', 'responsive-tables']);

		// Build menu tree for the top bar
		$menu = new Node('menu', [
			self::buildTree()->addChild(AdminPanelMenuComposer::buildTree())
		]);
		
		$rightmenu = new Node('rightmenu', [
			AdminPanelMenuComposer::buildSecondaryTree()
		]);

		// Pass menu to the view
		$view->with('menu', $menu->setRender(new FoundationTopBar())->purge())->with('rightmenu', $rightmenu->setRender(new FoundationTopBar())->purge());
	}

	/**
	 * Build the main tree.
	 *
	 * @return Menu\Node
	 */
	public static function buildTree()
	{
		extract(self::makeSections(auth()->user()));

		return new Node(_('Reports'), [
			$sampleReport,
		]);
	}

	/**
	 * Define the main sections of the menu.
	 *
	 * @param  User $user User to checked permissions against
	 *
	 * @return array (of Menu\Node)
	 */
	public static function makeSections(User $user)
	{
		$sampleReport = (app()->environment('local')) ? new Link(route('report.sample'), with(new \App\Http\Controllers\Reports\SampleReport)->title()) : new Node();
		#_REPORT_GENERATOR_MARKER_#_DO_NOT_REMOVE_#

		return compact('sampleReport');
	}
}
