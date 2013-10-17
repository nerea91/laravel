<?php namespace Stolz;

use Illuminate\Console\Command;
use Illuminate\View\Compilers\BladeCompiler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use File;

class GettextCommand extends Command {

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
	public function __construct ()
	{
		parent::__construct();
	}

	/**
	* Execute the console command.
	*
	* @return void
	*/
	public function fire ()
	{
		//Set directories
		$input_path = app_path() . DIRECTORY_SEPARATOR . 'views';
		$output_path = storage_path() . DIRECTORY_SEPARATOR . 'gettext' . DIRECTORY_SEPARATOR;

		//Create or empty $output_path
		if (File::isDirectory($output_path))
			File::cleanDirectory($output_path);
		else
			File::makeDirectory($output_path);

		//Configure BladeCompiler to use our own custom storage subfolder
		$compiler = new BladeCompiler(new \Illuminate\Filesystem\Filesystem, $output_path);
		$compiled = 0;

		//Get all view files
		$all_files = File::allFiles($input_path);
		foreach($all_files as $f)
		{
			//Skip not blade templates
			$file = $f->getPathName();
			if('.blade.php' != substr($file, -10))
				continue;

			//Compile the view
			$compiler->compile($file);
			$compiled++;

			//Rename to human friendly
			$human =  str_replace(DIRECTORY_SEPARATOR , '-', ltrim($f->getRelativePathname(), DIRECTORY_SEPARATOR));
			File::move($output_path . md5($file), $output_path . $human . '.php');
		}

		if($compiled)
		{
			$this->info("$compiled files compiled. Now you should run:");
			$this->comment(app_path().'/lang/gettext.sh');
		}
		else
			$this->error('No .blade.php files found in '.$input_path);
	}

	/**
	* Get the console command arguments.
	*
	* @return array
	*/
	protected function getArguments ()
	{
		return array();
	}

	/**
	* Get the console command options.
	*
	* @return array
	*/
	protected function getOptions ()
	{
		/**
		* return the options array
		*/
		return array();
	}
}
