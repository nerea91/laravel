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
		View::share('search_results', Cache::get('adminSearchResults' . Auth::user()->getKey(), false));

		$this->layout->title = _('Admin panel');
		$this->layout->subtitle = _('Search');
		$this->layout->content = View::make('admin.search');
	}

	/**
	 * Search all resources that current user has read access.
	 *
	 * NOTE: Even search results are asociated to an user they are persisted
	 * using CACHE instead of COOKIE because too big search results may lead
	 * to excesively big HTTP headers resulting in a web server error response.
	 * When the user logs out an event handler will purge the search results
	 * from cache.
	 *
	 * @return Response
	 */
	public function search()
	{
		$query = Input::get('search');
		$user = Auth::user();
		$cache_id = 'adminSearchResults' . $user->getKey();

		if(strlen($query) > 0)
		{
			$results = [];
			$total_results = 0;
			$current_route = Route::current()->getName();
			$searchable_models = [
				60 => 'User',
				100 => 'Account',
				40 => 'Profile',
				60 => 'AuthProvider',
				120 => 'Currency',
				20 => 'Language',
				10 => 'Country',
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
				Cache::put($cache_id, $results, 5);
				Session::flash('success', sprintf(_('%d results found'), $total_results));
			}
			else
			{
				Cache::forget($cache_id);
				Session::flash('error', _('No results found'));
			}
		}
		else
			Cache::forget($cache_id);

		return Redirect::route('admin')->withInput();
	}

}
