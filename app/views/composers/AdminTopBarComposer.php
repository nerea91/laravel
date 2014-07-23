<?php

use Stolz\Menu\Nodes\Flat;
use Stolz\Menu\Nodes\Link;
use Stolz\Menu\Nodes\Node;
use Stolz\Menu\Renders\FoundationTopBar;

class AdminTopBarComposer
{
	public function compose($view)
	{
		// User to check permissions against
		$user = Auth::user();

		// Define all the available sections
		$sections = $this->makeSections($user);

		// Build menu tree
		$menu = $this->buildTree($sections);

		// Set a menu render
		$menu->setRender(new FoundationTopBar());

		// Pass menu to view
		$view->with('menu', $menu);
	}

	/**
	 * Define all the sections that the menu may have.
	 *
	 * @param  User $user User to checked permissions against
	 * @return array
	 */
	public function makeSections(User $user)
	{
		/** Admin Panel secctions (in alphabetical order) **/

		// Section: Accounts
		$accounts = new Flat(_('Accounts'));
		if($user->hasPermission(100))
			$accounts->addChild(new Link(route('admin.accounts.index'), _('Index')));
		if($user->hasPermission(101))
			$accounts->addChild(new Link(route('admin.accounts.create'), _('Add')));

		// Section: Countries
		$countries = new Flat(_('Countries'));
		if($user->hasPermission(10))
			$countries->addChild(new Link(route('admin.countries.index'), _('Index')));
		if($user->hasPermission(11))
			$countries->addChild(new Link(route('admin.countries.create'), _('Add')));

		// Section: Currencies
		$currencies = new Flat(_('Currencies'));
		if($user->hasPermission(120))
			$currencies->addChild(new Link(route('admin.currencies.index'), _('Index')));
		if($user->hasPermission(121))
			$currencies->addChild(new Link(route('admin.currencies.create'), _('Add')));

		// Section: Languages
		$languages = new Flat(_('Languages'));
		if($user->hasPermission(20))
			$languages->addChild(new Link(route('admin.languages.index'), _('Index')));
		if($user->hasPermission(21))
			$languages->addChild(new Link(route('admin.languages.create'), _('Add')));

		// Section: Profiles
		$profiles = new Flat(_('Profiles'));
		if($user->hasPermission(40))
			$profiles->addChild(new Link(route('admin.profiles.index'), _('Index')));
		if($user->hasPermission(41))
			$profiles->addChild(new Link(route('admin.profiles.create'), _('Add')));

		// Section: Providers
		$providers = new Flat(_('Providers'));
		if($user->hasPermission(80))
			$providers->addChild(new Link(route('admin.authproviders.index'), _('Index')));
		if($user->hasPermission(81))
			$providers->addChild(new Link(route('admin.authproviders.create'), _('Add')));

		// Section: Users
		$users = new Flat(_('Users'));
		if($user->hasPermission(60))
			$users->addChild(new Link(route('admin.users.index'), _('Index')));
		if($user->hasPermission(61))
			$users->addChild(new Link(route('admin.users.create'), _('Add')));

		/** Current user section **/

		$userPanel = new Node($user->name());
		$userPanel->addChild(new Link(route('user.options'), _('Options')));
		$userPanel->addChild(new Link(route('logout'), _('Logout'), ['class' => 'button alert', 'style' => 'padding:0']));

		/** Change application language section **/

		$currentLanguage = App::make('language');
		$allLanguages = Language::getAllByPriority();
		$changeLanguage = new Node($currentLanguage);

		if($allLanguages->count() > 1)
		{
			$newLanguages = new Flat(_('Change language'));
			foreach($allLanguages as $l)
				if($l->id != $currentLanguage->id) // Do not add current language
					$newLanguages->addChild(new Link(route('language.set', ['code' => $l->code]), $l->name));

			$changeLanguage->addChild($newLanguages);
		}

		return compact('accounts', 'countries', 'currencies', 'languages', 'profiles', 'providers', 'users', 'userPanel', 'changeLanguage');
	}

	/**
	 * Create a tree struture from $sections.
	 *
	 * @param  array
	 * @return Menu\Node
	 */
	public function buildTree(array $sections)
	{
		extract($sections);

		$menu = new Node('menu', [
			new Node('left', [
				new Node(_('Users'), [
					$users,
					$profiles,
				]),
				new Node(_('Access'), [
					$accounts,
					$providers,
				]),
				new Node(_('Localization'), [
					$languages,
					$countries,
					$currencies,
				]),
			]),
			new Node('right', [
				$userPanel,
				$changeLanguage,
			]),
		]);

		return $menu->purge();
	}
}
