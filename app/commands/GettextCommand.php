<?php namespace Stolz\Artisan;

use Illuminate\Console\Command;
use Illuminate\View\Compilers\BladeCompiler;
use File;

class GettextCommand extends Command
{

	/**
	* The console command name.
	*
	* @var string
	*/
	protected $name = 'gettext';

	/**
	* The console command description.
	*
	* @var string
	*/
	protected $description = 'Compiles Blade templates into PHP for GNU gettext to be able to parse them';

	/**
	* Create a new command instance.
	*
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	* Execute the console command.
	*
	* @return void
	*/
	public function fire()
	{
		//Set directories
		$inputPath = app_path() . DIRECTORY_SEPARATOR . 'views';
		$outputPath = storage_path() . DIRECTORY_SEPARATOR . 'gettext' . DIRECTORY_SEPARATOR;

		//Create or empty $outputPath
		if (File::isDirectory($outputPath))
			File::cleanDirectory($outputPath);
		else
			File::makeDirectory($outputPath);

		//Configure BladeCompiler to use our own custom storage subfolder
		$compiler = new BladeCompiler(new \Illuminate\Filesystem\Filesystem, $outputPath);
		$compiled = 0;

		//Get all view files
		$allFiles = File::allFiles($inputPath);
		foreach($allFiles as $f)
		{
			//Skip not blade templates
			$file = $f->getPathName();
			if('.blade.php' != substr($file, -10))
				continue;

			//Compile the view
			$compiler->compile($file);
			$compiled++;

			//Rename to human friendly
			$human =  str_replace(DIRECTORY_SEPARATOR, '-', ltrim($f->getRelativePathname(), DIRECTORY_SEPARATOR));
			File::move($outputPath . md5($file), $outputPath . $human . '.php');
		}

		if($compiled)
			$this->info("$compiled files compiled.");
		else
			$this->error('No .blade.php files found in '.$inputPath);
	}

	/**
	* Get the console command arguments.
	*
	* @return array
	*/
	protected function getArguments()
	{
		return array();
	}

	/**
	* Get the console command options.
	*
	* @return array
	*/
	protected function getOptions()
	{
		/**
		* return the options array
		*/
		return array();
	}
}
