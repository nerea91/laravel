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
		// Get results from previous search
		View::share('search_results', Cache::get('adminSsearchResults', false));

		$this->layout->title = _('Admin panel');
		$this->layout->subtitle = _('Search');
		$this->layout->content = View::make('admin.search');
	}

	/**
	 * Search all resources that current user has read access
	 *
	 * @return Response
	 */
	public function search()
	{
		$query = Input::get('search');

		if(strlen($query) > 0)
		{
			$results = [];
			$total_results = 0;
			$user = Auth::user();
			$current_route = Route::current()->getName();
			$searchable_models = [
				60 => 'User',
				100 => 'Account',
				40 => 'Profile',
				20 => 'Language',
				10 => 'Country',
				60 => 'AuthProvider',
				120 => 'Currency',
			];

			// Perform search for all searchable models
			foreach($searchable_models as $permission => $model_name)
			{
				if($user->hasPermission($permission))
				{
					$model = new $model_name;
					$collection = $model->search($query);
					if( ! $count = $collection->count())
						continue;

					$total_results += $count;
					$result = new stdClass();
					$result->label = $model->plural();
					$result->route = replace_last_segment($current_route, strtolower(str_plural($model_name)).'.show');
					$result->collection = $collection;
					$results[$model_name] = $result;
				}
			}

			// Store results in the cache for 5 minutes
			if($results)
			{
				Cache::put('adminSsearchResults', $results, 5);
				Session::flash('success', sprintf(_('%d results found'), $total_results));
			}
			else
			{
				Session::flash('error', _('No results'));
				Cache::forget('adminSsearchResults');
			}
		}
		else
			Cache::forget('adminSsearchResults');

		return Redirect::route('admin')->withInput();;
	}

}

