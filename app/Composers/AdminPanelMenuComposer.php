<?php namespace App\Composers;

use App\Language;
use App\User;
use Stolz\Menu\Nodes\Flat;
use Stolz\Menu\Nodes\Link;
use Stolz\Menu\Nodes\Node;
use App\Renders\FoundationTopBar;

class AdminPanelMenuComposer
{
	public function compose($view)
	{
		\Assets::add('admin');

		// Build menu tree for the top bar
		$menu = new Node('menu', [
			self::buildTree()->addChild(ReportsMenuComposer::buildTree())
		]);
		
		$rightmenu = new Node('rightmenu', [
			self::buildSecondaryTree()
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

		return new Node(_('Dashboard'), [
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
			new Node(_('Documents'), [
				$documents,
				$documentsList,
			]),
		]);
	}

	/**
	 * Build the secondary tree.
	 *
	 * @return Menu\Node
	 */
	public static function buildSecondaryTree()
	{
		extract(self::makeSecondarySections(auth()->user()));

		return new Node('right', [
			$userPanel,
			$changeLanguage,
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

		// Section: Documents
		$documents = new Node(_('Manage'));
		if($user->hasPermission(140))
			$documents->addChild(new Link(route('admin.documents.index'), _('Index')));
		if($user->hasPermission(141))
			$documents->addChild(new Link(route('admin.documents.create'), _('Add')));

		// Section: DocumentsList
		$documentsList = new Flat(_('Read'));
		foreach($user->profile->getDocuments() as $id => $title)
			$documentsList->addChild(new Link(route('document', ['id' => $id, 'title' => $title]), $title));

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

		#_RESOURCE_GENERATOR_MARKER_#_DO_NOT_REMOVE_#

		return compact('accounts', 'countries', 'currencies', 'documents', 'documentsList', 'languages', 'profiles', 'providers', 'users');
	}

	/**
	 * Define the secondary sections of the menu.
	 *
	 * @param  User $user User to checked permissions against
	 *
	 * @return array (of Menu\Node)
	 */
	public static function makeSecondarySections(User $user)
	{
		// Section: Change application language
		$currentLanguage = app('language');
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

		// Section: User panel
		$userPanel = new Node($user->name());
		$userPanel->addChild(new Link(route('user.options'), _('Options')));
		$userPanel->addChild(new Link(route('logout'), _('Logout'), ['class' => 'button alert expanded', 'style' => 'height:auto;']));

		return compact('changeLanguage', 'userPanel');
	}
}
