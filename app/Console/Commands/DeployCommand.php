<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use SSH;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DeployCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'deploy';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deploy this application to a server via SSH';

	/**
	 * Default connection.
	 *
	 * @var string
	 */
	protected $defaultConnection;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// Get default connection
		$this->defaultConnection = SSH::getDefaultConnection();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Connection (Server) that will be used
		$connection = $this->argument('connection') ?: $this->defaultConnection;

		// If --list option is provided stop the process
		if ($this->option('list'))
			return $this->showList($connection);

		// Commands that will be executed on remote server
		$commands = [
			//TODO set the necessary commands for deployment
			//'cd /var/www/myproject',
			//'git pull origin mybranch',
			'pwd',
		];

		// Override connection password
		if ($this->option('password'))
			config(["remote.connections.$connection.password" => $this->secret('What is the password?')]);

		$this->info('Deploying to ' . $connection);

		// Run the commands and show their output
		SSH::into($connection)->run($commands, function ($line) {
			$this->line($line);
		});
	}

	/**
	 * Show a list with all the available connections.
	 *
	 * @param  string
	 * @return void
	 */
	protected function showList($selectedConnection)
	{
		$data = [];
		foreach(config('remote.connections') as $name => $info)
		{
			$data[] = [
				$name,
				$info['host'],
				$info['username'],
				$info['root'],
				($name == $this->defaultConnection) ? 'Yes' : 'No',
				($name == $selectedConnection) ? 'Yes' : 'No',
			];
		}

		$this->info('Available server connection:');
		$this->table(['Connection', 'Host', 'Username', 'Directory', 'Default', 'Selected'], $data);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['connection', InputArgument::OPTIONAL, 'Connection from app/config/remote.php that will be used.', $this->defaultConnection],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['list', 'l', InputOption::VALUE_NONE, 'List all available connections'],
			['password', 'p', InputOption::VALUE_NONE, 'Instead of using the connection password prompt for a new one'],
		];
	}
}
