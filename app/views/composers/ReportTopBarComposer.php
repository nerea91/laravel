<?php

use Stolz\Menu\Nodes\Flat;
use Stolz\Menu\Nodes\Link;
use Stolz\Menu\Nodes\Node;
use Stolz\Menu\Renders\FoundationTopBar;

class ReportTopBarComposer
{
	public function compose($view)
	{
		// User to check permissions against
		$user = Auth::user();

		// Define all the available sections
		$sections = array_merge(self::makeSections($user), AdminTopBarComposer::makeSecondarySections($user));
		$sections['dashboard'] = AdminTopBarComposer::makeSections($user);

		// Build menu tree
		$menu = self::buildTree($sections);

		// Set a menu render
		$menu->setRender(new FoundationTopBar());

		// Pass menu to view
		$view->with('menu', $menu);
	}

	/**
	 * Define the main sections of the menu.
	 *
	 * @param  User $user User to checked permissions against
	 * @return array
	 */
	public static function makeSections(User $user)
	{
		$sampleReport = (App::environment('local')) ? new Link(route('report.sample'), with(new SampleReport)->title()) : new Node();

		return compact('sampleReport');
	}

	/**
	 * Create a tree struture from $sections.
	 *
	 * @param  array
	 * @return Menu\Node
	 */
	public static function buildTree(array $sections)
	{
		extract($sections);

		$menu = new Node('menu', [
			new Node('left', [
				$sampleReport
			]),
			new Node('right', [
				new Node(_('Dashboard'), $dashboard),
				$userPanel,
				$changeLanguage,
			]),
		]);

		return $menu->purge();
	}
}
