<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Cache;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	use ValidatesRequests;

	protected $layout = 'layouts.admin';

	protected $searchableModels = [
		10  => \App\Country::class,
		20  => \App\Language::class,
		40  => \App\Profile::class,
		60  => \App\User::class,
		80  => \App\AuthProvider::class,
		100 => \App\Account::class,
		120 => \App\Currency::class,
		140 => \App\Document::class,
	];

	/**
	 * Show admin control panel main page
	 *
	 * @return Response
	 */
	public function showAdminPage(Request $request)
	{
		$user = $request->user();
		$models = $this->getSearchableModels($user);

		// Sort models by plural name
		foreach($models as $permission => $model)
			$models[$permission] = $model->plural();
		asort($models);

		// Get results from previous search
		$searchResults = Cache::get('adminSearchResults' . $user->getKey(), false);

		// Add data to the view
		$view = view('admin.search', [
			'searchResults' => $searchResults,
			'models' => $models,
		]);

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
	public function search(Request $request)
	{
		$user = $request->user();
		$searchableModels = $this->getSearchableModels($user);

		// Validate form
		$this->validate($request, [
			'query' => 'required|min:1',
			'sections' => 'required|array|in:' . implode(',', array_keys($searchableModels))
		]);

		// Remove unselected models
		$selectedModels = $request->input('sections', []);
		foreach($searchableModels as $permission => $model)
			if( ! in_array($permission, $selectedModels))
				unset($searchableModels[$permission]);

		// Initializate results
		$query = $request->input('query');
		$session = $request->session();
		$currentRoute =  $request->route()->getName();
		$cacheId = 'adminSearchResults' . $user->getKey();
		$results = collect();
		$totalResults = 0;

		// Perform search for all searchable models
		foreach($searchableModels as $model)
		{
			$collection = $model->search($query);
			if( ! $count = $collection->count())
				continue;

			$totalResults += $count;
			$modelName = class_basename($model);

			// Build results object
			$result = new \stdClass();
			$result->label = $model->plural();
			$result->route = replace_last_segment($currentRoute, strtolower(str_plural($modelName)) . '.show');
			$result->collection = $collection;
			$results[$modelName] = $result;
		}

		// Results found
		if($results->count())
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
			$session->flash('success', sprintf(_('%d results found'), $totalResults));
		}
		// No results found
		else
		{
			Cache::forget($cacheId);
			$session->flash('error', _('No results found'));
		}

		return redirect()->route('admin')->withInput();
	}

	/**
	 * Get the models that provided $user is allowed to seach.
	 *
	 * @param   App\User $user
	 *
	 * @return array
	 */
	protected function getSearchableModels(\App\User $user)
	{
		$models = [];

		// Filter
		foreach($this->searchableModels as $permission => $modelName)
			if($user->hasPermission($permission))
				$models[$permission] = new $modelName;

		return $models;
	}
}
