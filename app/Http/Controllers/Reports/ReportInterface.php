<?php namespace App\Http\Controllers\Reports;

interface ReportInterface
{
	/**
	 * Get report title.
	 *
	 * @return string
	 */
	public function title();

	/**
	 * Get report subtitle.
	 *
	 * @return string
	 */
	public function subtitle();

	/**
	 * Set report subtitle.
	 *
	 * @param  array
	 *
	 * @return ReportInterface
	 */
	public function setSubtitle(array $data = []);

	/**
	 * If input is not valid flash errors.
	 *
	 * @return Response
	 */
	public function validate();

	/**
	 * Get report resutls.
	 *
	 * @param  array
	 *
	 * @return mixed NOTE If no results are found the returned value MUST evaluate to false.
	 */
	public function get(array $data);

	/**
	 * Show report results.
	 *
	 * @return Response
	 */
	public function show();
}
