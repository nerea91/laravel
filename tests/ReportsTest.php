<?php

class ReportsTest extends TestCase
{
	/**
	 * @before
	 */
	protected function clearCache()
	{
		$this->artisan('cache:clear');
	}

	protected function common($route, array $input = [], $marker = 'REPORT-RESULTS-MARKER')
	{
		$user = $this->getSuperUser();
		$page = route($route);
		$button = _('Submit');

		$this
		->actingAs($user)
		->visit($page)
		->submitForm($button, $input)
		->seePageIs($page)
		->assertSessionHasNoErrors($route)
		->see($marker);
	}

	public function testSampleReport()
	{
		$this->common('report.sample', [], 'summary="report-results"');
	}

	#_REPORT_GENERATOR_MARKER_#_DO_NOT_REMOVE_#
}
