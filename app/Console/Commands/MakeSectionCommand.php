<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

abstract class MakeSectionCommand extends Command
{
	/**
	 * The routes file path.
	 *
	 * @var string
	 */
	protected $routesFile;

	/**
	 * The ACL config file path.
	 *
	 * @var string
	 */
	protected $aclFile;

	/**
	 * The permission's seeder file path.
	 *
	 * @var string
	 */
	protected $permissionSeederFile;

	/**
	 * The view composer file path.
	 *
	 * @var string
	 */
	protected $composerFile;

	/**
	 * The unit tests file path.
	 *
	 * @var string
	 */
	protected $testFile;

	/**
	 * The marker used for file replacement.
	 *
	 * @var string
	 */
	protected $marker;

	/**
	 * The section controller class name, without namespace.
	 *
	 * @var string
	 */
	protected $class;

	/**
	 * Sufix of the class name.
	 *
	 * @var string
	 */
	protected $sufix;

	/**
	 * The route short name of the new section.
	 *
	 * @var string
	 */
	protected $route;

	/**
	 * The required permission number.
	 *
	 * @var integer
	 */
	protected $permission;

	/**
	 * The required permission type number.
	 *
	 * @var integer
	 */
	protected $permissionType;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// Set files path
		$this->routesFile = base_path('routes/web.php');
		$this->permissionSeederFile = base_path('database/seeds/PermissionsTableSeeder.php');
		$this->aclFile = config_path('acl.php');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Read command parameters and options.
		$this->route = $this->argument('route');
		$this->permission = $this->argument('permission');
		$this->permissionType = $this->argument('permissionType');

		// Add permission to the seeder file
		if( ! $this->addToSeeder())
			return $this->error('Unable to add permission to the seeder file');

		// Add permissions to the ACL file
		if( ! $this->addToAcl())
			return $this->error('Unable to add permission to the ACL file');

		// Add route to the routes file
		if( ! $this->addToRoutes())
			return $this->error('Unable to add route to the routes file');

		// Add menu menu entry to the ViewComposer file
		if( ! $this->addToMenu())
			return $this->error('Unable to create menu entry');

		// Add test to the unit tests file
		if( ! $this->addToTests())
			return $this->error('Unable to add test to the tests file');

		// Create the controller file
		if( ! $this->createController())
			return $this->error('Unable to create controller');

		// Create the view file
		if( ! $this->createView())
			return $this->error('Unable to create view');

		return $this->info('OK');
	}

	/**
	 * Set marker.
	 *
	 * @param  string
	 *
	 * @return self
	 */
	public function setMarker($marker)
	{
		$this->marker = $marker;

		return $this;
	}

	/**
	 * Set composer file.
	 *
	 * @param  string
	 *
	 * @return self
	 */
	public function setComposerFile($file)
	{
		$this->composerFile = $file;

		return $this;
	}

	/**
	 * Set unit tests file.
	 *
	 * @param  string
	 *
	 * @return self
	 */
	public function setTestFile($file)
	{
		$this->testFile = $file;

		return $this;
	}

	/**
	 * Set controller class name.
	 *
	 * @param  string
	 *
	 * @return self
	 */
	public function setClass($sufix)
	{
		$this->class = preg_replace("/$sufix$/", '', $this->argument('class')); // Remove sufix from class name
		$this->sufix = $sufix;

		return $this;
	}

	/**
	 * Inserts content on a file right above the line that contains the marker.
	 *
	 * @param  string       $file
	 * @param  string|array $content
	 *
	 * @return bool
	 */
	protected function addContentBeforeMarker($file, $content)
	{
		// Read file into array of lines
		$lines = file($file);
		if($lines === false)
			return false;

		// Search for the marker on each line
		foreach($lines as $lineNumber => $line)
		{
			$position = strpos($line, $this->marker);
			// Marker found
			if($position !== false)
			{
				// Format content
				$content = (array) $content;
				$identation = substr($line, 0, $position);
				foreach($content as $key => $value)
					$content[$key] = (strlen($value)) ? $identation . $value . PHP_EOL : PHP_EOL;

				// Insert content above the marker
				$above = array_slice($lines, 0, $lineNumber);
				$below = array_slice($lines, $lineNumber);
				$lines = array_merge($above, $content, $below);

				// Replace original file
				return (bool) file_put_contents($file, implode($lines));
			}
		}

		return false;
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
		$file = $this->permissionSeederFile;
		$content = func_get_args();

		return $this->addContentBeforeMarker($file, $content);
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
		$file = $this->aclFile;
		$content = func_get_args();

		return $this->addContentBeforeMarker($file, $content);
	}

	/**
	 * Add route to the routes file.
	 *
	 * @return boolean
	 */
	protected function addToRoutes()
	{
		$file = $this->routesFile;
		$content = "'{$this->route}' => '{$this->class}{$this->sufix}',";

		return $this->addContentBeforeMarker($file, $content);
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
		$file = app_path('Composers/' . $this->composerFile);
		$content = func_get_args();

		return $this->addContentBeforeMarker($file, $content);
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
		$file = base_path('tests/' . $this->testFile);
		$content = func_get_args();

		return $this->addContentBeforeMarker($file, $content);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['route', InputArgument::REQUIRED, 'The route name. i.e: foo.bar'],
			['class', InputArgument::REQUIRED, 'The controller class name. i.e: FooBar'],
			['permission', InputArgument::REQUIRED, 'The required permission'],
			['permissionType', InputArgument::REQUIRED, 'The type of the required permission'],
		];
	}
}
