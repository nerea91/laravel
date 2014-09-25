<?php namespace App\Http\Filters;

use Response;

class MaintenanceFilter
{
	/**
	 * Run the request filter.
	 *
	 * @return mixed
	 */
	public function filter()
	{
		if (app()->isDownForMaintenance())
		{
			return Response::view('errors.maintenance', array('title' => _('Maintenance')), 503);
		}
	}
}
