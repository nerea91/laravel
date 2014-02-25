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
	 * Search in all resources that current user has read access
	 *
	 * @return Response
	 */
	public function search()
	{
		Input::flashOnly('search');
		$query = Input::get('search');
		$user = Auth::user();
		$results = [];
		$current_route = Route::current()->getName();

		if(strlen($query) > 0)
		{
			$searchable_models = [
				60 => 'User',
				100 => 'Account',
				40 => 'Profile',
				20 => 'Language',
				10 => 'Country',
				60 => 'AuthProvider',
				120 => 'Currency',
			];

			// Perform search in all searchable models
			foreach($searchable_models as $permission => $model_name)
			{
				if($user->hasPermission($permission))
				{
					$model = new $model_name;
					$collection = $model->search($query);
					if( ! $count = $collection->count())
						continue;

					$result = new stdClass();
					$result->label = $model->plural();
					$result->route = replace_last_segment($current_route, strtolower(str_plural($model_name)).'.show');
					$result->collection = $collection;
					$results[$model_name] = $result;
				}
			}

			if( ! $results)
				Session::flash('error', _('No results'));
		}

		View::share('searchResults', $results);

		return $this->showAdminPage();//to-do esto deberia ser un redirect para que cuando volvamos a tras el navegafor no pregunte si reenviar el form
	}

}

