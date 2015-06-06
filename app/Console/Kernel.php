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
		//TODO 'App\Console\Commands\DeployCommand',
		'App\Console\Commands\GettextCommand',
		'App\Console\Commands\MakeReportCommand',
		'App\Console\Commands\MakeResourceCommand',
		'App\Console\Commands\SetupCommand',
		'App\Console\Commands\SetupCountriesCommand',
		'App\Console\Commands\SetupCurrenciesCommand',
		'App\Console\Commands\SetupLanguagesCommand',
		'App\Console\Commands\SetupSuperUserCommand',
		'App\Console\Commands\SyncDatabaseMetaTablesCommand',
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
