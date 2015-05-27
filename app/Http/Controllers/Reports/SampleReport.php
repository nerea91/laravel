<?php namespace App\Http\Controllers\Reports;

use App\Currency;
use Carbon\Carbon;

class SampleReport extends ReportController implements ReportInterface
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
		/*$this->data['formats'] = [
			'web' => _('Web'),
			'json' => _('Json'),
			'xls' => _('Excel')
		];*/
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
			'reports.' . class_basename(__CLASS__),
			// Form validation
			[
				//'format' => [_('Format'), 'in:'.implode(array_keys($this->data['formats']), ',')],
				'date1' => [_('From date'), 'required|date'],
				'date2' => [_('To date'), 'required|date'],
				'group_by' => [_('Group by'), 'required|in:'.implode(array_keys($this->data['group_by']), ',')],
			],
			// Form default values
			[
				//'format' => 'web',
				'date1' => Carbon::yesterday()->toDateString(),
				'date2' => Carbon::now()->toDateString(),
				'group_by' => 'week',
			]
			// Off-canvas class
			//,'custom-width-off-canvas'
		);
	}

	/**
	 * Set report subtitle.
	 *
	 * @param  array $data
	 * @return self
	 */
	public function setSubtitle(array $data = [])
	{
		$date1 = new Carbon($data['date1']);
		$date2 = new Carbon($data['date2']);

		$this->subtitle = sprintf(
			_('Results between %s and %s grouped by %s'),
			$date1->formatLocalized('%A %d %B %Y'),
			$date2->formatLocalized('%A %d %B %Y'),
			strtolower($this->data['group_by'][$data['group_by']])
		);

		return $this;
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
		$data = new \StdClass();

		$data->rows = [
			(object) ['number' => 1234, 'currency' => 1234.56, 'percentage' => 33.33],
			(object) ['number' => 5678, 'currency' => 9012.34, 'percentage' => 66.66],
		];

		$data->totals = (object) ['number' => 6912, 'currency' => 10246.9, 'percentage' => 99.99];

		$data->currency = Currency::first();

		return $data;
	}
}
