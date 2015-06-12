<?php namespace App\Console\Commands;

class MakeReportCommand extends MakeSectionCommand
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:report';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a new report controller';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Initialize class properties
		$this->setMarker('#_REPORT_GENERATOR_MARKER_#_DO_NOT_REMOVE_#');
		$this->setComposerFile('ReportsMenuComposer.php');
		$this->setClass($sufix = 'Report');

		// Fire command
		parent::fire();
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
		$content = sprintf(
			"['id' => %d, 'type_id' => %d, 'name' => _('%s %s %s')],",
			$this->permission,
			$this->permissionType,
			$this->class,
			$this->sufix,
			'TO' + 'DO'
		);

		return parent::addToSeeder($content);
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
			sprintf("'report.%s' => %d,", $this->route, $this->permission),
			sprintf("'report.%s.validate' => %d,", $this->route, $this->permission)
		);
	}

	/**
	 * Create the menu entry.
	 *
	 * @param  dynamic
	 *
	 * @return bool
	 */
	public function addToMenu()
	{
		$content = sprintf(
			"$%s = (\$user->hasPermission(%d)) ? new Link(route('report.%s'), _('%s %s %s')) : new Node();",
			camel_case(str_replace('.', '_', $this->class)),
			$this->permission,
			$this->route,
			$this->class,
			$this->sufix,
			'TO' + 'DO'
		);

		return parent::addToMenu($content);
	}

	/**
	 *  Create the controller file.
	 *
	 * @return bool
	 */
	public function createController()
	{
		$originalFile = app_path('Http/Controllers/Reports/SampleReport.php');
		$newFile = dirname($originalFile) . DIRECTORY_SEPARATOR . $this->class . $this->sufix . '.php';

		// Read original file
		if( ! $content = file_get_contents($originalFile))
			return false;

		// Replace class name
		$content = str_replace('SampleReport', $this->class . $this->sufix, $content);

		// Write new file
		return (bool) file_put_contents($newFile, $content);
	}

	/**
	 *  Create the view file.
	 *
	 * @return bool
	 */
	public function createView()
	{
		$originalFile = base_path('resources/views/reports/SampleReport.blade.php');
		$newFile = dirname($originalFile) . DIRECTORY_SEPARATOR . $this->class . $this->sufix . '.blade.php';

		return copy($originalFile, $newFile);
	}
}
