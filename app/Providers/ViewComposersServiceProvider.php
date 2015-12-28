<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposersServiceProvider extends ServiceProvider
{
	/**
	 * Register view composers.
	 *
	 * @return void
	 */
	public function boot()
	{
		view()->composers([
			//View composer class => View file (use an array for more than one)
			'App\Composers\AdminPanelMenuComposer'      => 'admin/top-bar',
			'App\Composers\SimilarProfilesComposer'     => 'admin.users.fields',
			'App\Composers\DebugBarComposer'            => 'layouts.base',
			'App\Composers\ApplicationLanguageComposer' => ['layouts.base', 'layouts.master', 'reports.datepicker'],
			'App\Composers\MasterMenuComposer'          => 'layouts.master',
			'App\Composers\ReportsMenuComposer'         => 'reports.top-bar',
			'App\Composers\IndexResultsComposer'         => 'admin.*.index',
		]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
