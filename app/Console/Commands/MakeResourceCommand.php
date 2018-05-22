<?php namespace App\Console\Commands;

class MakeResourceCommand extends MakeSectionCommand
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:resource';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a new resource controller';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		// Initialize class properties
		$this
		->setClass($sufix = 'Controller')
		->setMarker('#_RESOURCE_GENERATOR_MARKER_#_DO_NOT_REMOVE_#')
		->setComposerFile('AdminPanelMenuComposer.php')
		->setTestFile('ResourceControllerTest.php');

		// Fire command
		parent::handle();
	}

	/**
	 *  Add permissions to the seeder file.
	 *
	 * @param  dynamic
	 *
	 * @return bool
	 */
	public function addToSeeder()
	{
		return parent::addToSeeder(
			sprintf("// %s (Reserved range: %d-%d)", str_plural($this->class), $this->permission, $this->permission + 19),
			sprintf("['id' => %d, 'type_id' => %d, 'name' => _('View')],", $this->permission, $this->permissionType),
			sprintf("['id' => %d, 'type_id' => %d, 'name' => _('Add')],", $this->permission + 1, $this->permissionType),
			sprintf("['id' => %d, 'type_id' => %d, 'name' => _('Edit')],", $this->permission + 2, $this->permissionType),
			sprintf("['id' => %d, 'type_id' => %d, 'name' => _('Delete')],", $this->permission + 3, $this->permissionType),
			''
		);
	}

	/**
	 *  Add permissions to the ACL file.
	 *
	 * @param  dynamic
	 *
	 * @return bool
	 */
	public function addToAcl()
	{
		return parent::addToAcl(
			'// ' . str_plural($this->class),
			sprintf("'admin.%s.index' => %d,", $this->route, $this->permission),
			sprintf("'admin.%s.show' => %d,", $this->route, $this->permission),
			sprintf("'admin.%s.create' => %d,", $this->route, $this->permission + 1),
			sprintf("'admin.%s.store' => %d,", $this->route, $this->permission + 1),
			sprintf("'admin.%s.edit' => %d,", $this->route, $this->permission + 2),
			sprintf("'admin.%s.update' => %d,", $this->route, $this->permission + 2),
			sprintf("'admin.%s.destroy' => %d,", $this->route, $this->permission + 3),
			sprintf("'admin.%s.restore' => %d,", $this->route, $this->permission + 3),
			sprintf("'admin.%s.trash.mode' => %d,", $this->route, $this->permission + 3),
			''
		);
	}

	/**
	 * Add section to the menu ViewComposer file.
	 *
	 * @param  dynamic
	 *
	 * @return bool
	 */
	public function addToMenu()
	{
		$plural = str_plural($this->class);
		$lower = '$' . strtolower($plural);

		return parent::addToMenu(
			"// Section: $plural",
			"$lower = new Flat(_('$plural'));",
			sprintf("if(\$user->hasPermission(%d))", $this->permission),
			sprintf("	{$lower}->addChild(new Link(route('admin.%s.index'), _('Index')));", $this->route),
			sprintf("if(\$user->hasPermission(%d))", $this->permission + 1),
			sprintf("	{$lower}->addChild(new Link(route('admin.%s.create'), _('Add')));", $this->route)
		);
	}

	/**
	 * Add function to the unit tests file.
	 *
	 * @param  dynamic
	 *
	 * @return bool
	 */
	public function addToTests()
	{
		return parent::addToTests(
			sprintf('public function testCreate%s()', $this->class),
			'{',
			sprintf("\t\$this->resource('%s')->create([", $this->route),
			sprintf("\t\t'foo' => 'TO%s',", 'DO'),
			"\t]);",
			"}\n",
			"\n",
			sprintf('public function testDelete%s()', $this->class),
			'{',
			sprintf("\t\$this->resource('%s')->destroy(TO%s);", $this->route, 'DO'),
			"}\n"
		);
	}

	/**
	 *  Create the controller file.
	 *
	 * @return bool
	 */
	public function createController()
	{
		$originalFile = app_path('Http/Controllers/Admin/AuthProvidersController.php');
		$newFile = dirname($originalFile) . DIRECTORY_SEPARATOR . $this->class . $this->sufix . '.php';

		// Read original file
		if( ! $content = file_get_contents($originalFile))
			return false;

		// Replace class name
		$content = str_replace('AuthProvidersController', $this->class . $this->sufix, $content);

		// Replace model class name
		$content = str_replace('AuthProvider', str_singular($this->class), $content);

		// Replace permissions
		$content = str_replace(80, $this->permission, $content);
		$content = str_replace(81, $this->permission + 1, $content);
		$content = str_replace(82, $this->permission + 2, $content);
		$content = str_replace(83, $this->permission + 3, $content);
		$content = str_replace(100, 'TODO', $content);

		// Write new file
		return (bool) file_put_contents($newFile, $content);
	}

	/**
	 *  Create the view files.
	 *
	 * @return bool
	 */
	public function createView()
	{
		$sourceDir = base_path('resources/views/admin/authproviders');
		$destinationDir = dirname($sourceDir) . DIRECTORY_SEPARATOR . strtolower(str_plural($this->class));

		return \File::copyDirectory($sourceDir, $destinationDir);
	}
}
