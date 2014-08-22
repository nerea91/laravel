<?php

class SampleReport extends BaseReportController implements ReportInterface
{
	/**
	 * Class constructor.
	 *
	 * Initialize class properties.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Add extra variables to the view
		$this->data['group_by'] = [
			'day' => _('Day'),
			'week' => _('Week'),
			'month' => _('Month'),
		];

		// Initialize report
		parent::__construct(
			// Title
			_('Sample report'),
			// View file
			'reports.' . __CLASS__,
			// Form validation
			[
				'date1' => [_('From date'), 'required|date'],
				'date2' => [_('To date'), 'required|date'],
				'group_by' => [_('Group by'), 'required|in:'.implode(array_keys($this->data['group_by']), ',')],
			],
			// Form default values
			[
				'date1' => Carbon\Carbon::yesterday()->toDateString(),
				'date2' => Carbon\Carbon::now()->toDateString(),
				'group_by' => 'week',
			]
			// Off-canvas class
			//,'custom-width-off-canvas'
		);
	}

	/**
	 * Set report subtitle.
	 *
	 * @param  array
	 * @return void
	 */
	public function setSubtitle(array $data = [])
	{
		$this->subtitle = sprintf(
			_('Results between %s and %s grouped by %s'),
			$data['date1'],
			$data['date2'],
			strtolower($this->data['group_by'][$data['group_by']])
		);
	}

	/**
	 * Get the report results.
	 *
	 * NOTE If no results are found the returned value MUST evaluate to false.
	 *
	 * @param  array    $data required to calculate the report results
	 * @return StdClass
	 *  ->rows
	 *  ->totals
	 *  ->currency
	 */
	public function get(array $data)
	{
		$data = new StdClass();

		$data->rows = [
			(object) ['number' => 1234, 'currency' => 1234.56, 'percentage' => 33.33],
			(object) ['number' => 5678, 'currency' => 9012.34, 'percentage' => 66.66],
		];

		$data->totals = (object) ['number' => 6912, 'currency' => 10246.9, 'percentage' => 99.99];

		$data->currency = Currency::first();

		return $data;
	}
}
