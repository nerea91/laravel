<?php

class AdminController extends BaseController {

	protected $layout = 'layouts.admin';

	/**
	 * Show admin control panel main page
	 *
	 * @return Response
	 */
	public function showAdminPage()
	{
		$this->layout->title = _('Admin panel');
		$this->layout->subtitle = _('Search');
		$this->layout->content = View::make('admin.search');
	}

	/**
	 * Search in all resources that current user has read access to
	 *
	 * @return Response
	 */
	public function search()
	{
		Input::flashOnly('search');
		$query = Input::get('search');
		$user = Auth::user();
		$results = [];

		if(strlen($query) > 0)
		{
			foreach([10 => 'Country'] as $permission => $model)
			{
				if($user->hasPermission($permission))
				{
					$model = new $model;
					$collection = $model->search($query);
					if( ! $count = $collection->count())
						continue;

					$results[($count == 1) ? $model->singular() :  $model->plural()] = $collection;
				}
			}

			if( ! $results)
				Session::flash('error', _('No results'));
		}

		$this->layout->title = _('Admin panel');
		$this->layout->subtitle = _('Search');
		$this->layout->content = View::make('admin.search')->with('searchResults', $results);
	}

}

