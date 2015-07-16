<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		\App\Console\Commands\DatabaseBackupCommand::class,
		//TODO \App\Console\Commands\DeployCommand::class,
		\App\Console\Commands\GettextCommand::class,
		\App\Console\Commands\MakeReportCommand::class,
		\App\Console\Commands\MakeResourceCommand::class,
		\App\Console\Commands\SetupCommand::class,
		\App\Console\Commands\SetupCountriesCommand::class,
		\App\Console\Commands\SetupCurrenciesCommand::class,
		\App\Console\Commands\SetupLanguagesCommand::class,
		\App\Console\Commands\SetupSuperUserCommand::class,
		\App\Console\Commands\SyncDatabaseMetaTablesCommand::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 *
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		//i.e: $schedule->command('inspire')->hourly();
	}
}
