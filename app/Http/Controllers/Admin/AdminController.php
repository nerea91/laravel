<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Cache;
use Illuminate\Support\Collection;
use Input;
use Route;
use Session;
use View;

class AdminController extends Controller
{
	protected $layout = 'layouts.admin';

	/**
	 * Show admin control panel main page
	 *
	 * @return Response
	 */
	public function showAdminPage()
	{
		// Get results from previous search
		$searchResults = Cache::get('adminSearchResults' . Auth::user()->getKey(), false);

		// Add data to the view
		$view = view('admin.search')->withSearchResults($searchResults);

		// Add data to the layout
		$this->layout->withTitle(_('Admin panel'))->withSubtitle(_('Search'));

		// Return layout + view
		return $this->layout($view);
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
		$cacheId = 'adminSearchResults' . $user->getKey();

		if(strlen($query) > 0)
		{
			$results = new Collection;
			$totalResults = 0;
			$currentRoute = Route::current()->getName();
			$searchableModels = [
				10  => 'Country',
				20  => 'Language',
				40  => 'Profile',
				60  => 'User',
				80  => 'AuthProvider',
				100 => 'Account',
				120 => 'Currency',
				140 => 'Document',
			];

			// Perform search for all searchable models
			foreach($searchableModels as $permission => $modelName)
			{
				if($user->hasPermission($permission))
				{
					$namespacedModel = "\App\\$modelName";
					$model = new $namespacedModel;
					$collection = $model->search($query);
					if( ! $count = $collection->count())
						continue;

					$totalResults += $count;
					$result = new \stdClass();
					$result->label = $model->plural();
					$result->route = replace_last_segment($currentRoute, strtolower(str_plural($modelName)) . '.show');
					$result->collection = $collection;
					$results[$modelName] = $result;
				}
			}

			// Results found
			if($results)
			{
				// Sort results showing first the models with smaller collections
				$results = $results->sort(function ($result1, $result2) {
					$count1 = $result1->collection->count();
					$count2 = $result2->collection->count();

					// Is same count order alphabetically
					if($count1 === $count2)
						return strcasecmp($result1->label, $result2->label);

					return ($count1 < $count2) ? -1 : 1;
				});

				// Store results in the cache for 5 minutes
				Cache::put($cacheId, $results, 5);
				Session::flash('success', sprintf(_('%d results found'), $totalResults));
			}
			// No results found
			else
			{
				Cache::forget($cacheId);
				Session::flash('error', _('No results found'));
			}
		}
		else
			Cache::forget($cacheId);

		return redirect()->route('admin')->withInput();
	}
}
