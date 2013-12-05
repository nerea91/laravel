<?php

/**
 * Common part for all resource controllers.
 */

class BaseResourceController extends BaseController {

	/**
	 * The layout that should be used for responses.
	 * @var string
	 */
	protected $layout;

	/**
	 * The common part of the name shared by all the routes of this resource controller.
	 * @var string
	 */
	protected $prefix;

	/**
	 * Instance of the resource that this controller is in charge of.
	 * @var Model
	 */
	protected $resource;

	/**
	 * Class constructor
	 *
	 * @param  Model $resource An instance of the resource this controller is in charge of.
	 * @param  array $permissions Permissions passed to the views
	 * @return void
	 */
	public function __construct($resource, array $permissions = array())
	{
		$this->resource = $resource;
		$this->prefix = $this->extractResourcePrefix(Route::currentRouteName());

		// Views require prefix to generate URLs and permissions to render buttons
		View::share(['prefix' => $this->prefix] + $permissions);
	}

	/**
	 * Same as $this->_index() but without type hinting.
	 *
	 * @return Response
	 */
	public function index()
	{
		return call_user_func_array([$this, '_index'], func_get_args());
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  Illuminate\Pagination\Paginator
	 * @param  array
	 * @return Response
	 */
	protected function _index(Illuminate\Pagination\Paginator $results = null, array $labels = null)
	{
		// If no results are provided use default resource pagination
		$results = ($results)?: $this->resource->paginate();

		// If results found add asset to make tables responsive
		//$results->getTotal() and Assets::add('responsive-tables');

		// If no labels are provided use default
		$labels = ($labels) ? (object) $labels : (object) $this->resource->getLabels();

		// Set the route for the return button
		$return = $this->extractResourcePrefix($this->prefix);

		$this->layout->title = $this->resource->plural();
		$this->layout->subtitle = _('Index');
		$this->layout->content = View::make('resource.index', compact('results', 'labels', 'return'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$data = [
			'resource'	=> $this->resource->findOrFail($id),
			'labels'	=> (object) $this->resource->getVisibleLabels(),
		];

		$this->layout->title = $this->resource->singular();
		$this->layout->subtitle = _('Details');
		$this->layout->content = View::make('resource.show', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = [
			'resource'	=> $this->resource,
			'labels'	=> (object) $this->resource->getFillableLabels(),
		];

		$this->layout->title = $this->resource->singular();
		$this->layout->subtitle = _('Add');
		$this->layout->content = View::make('resource.create', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data = [
			'resource'	=> $this->resource->findOrFail($id),
			'labels'	=> $this->resource->getFillableLabels(),
		];

		$this->layout->title = $this->resource->singular();
		$this->layout->subtitle = _('Edit');
		$this->layout->content = View::make('resource.edit', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$resource =  $this->resource->fill(Input::all()); //to-do revisar si es buena idea usar input all

		if( ! $resource->save())
			return Redirect::back()->withInput()->withErrors($resource->getErrors());

		Session::flash('success', sprintf(_('%s successfully created'), $resource));
		return Redirect::route("{$this->prefix}.show", $resource->getKey());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$resource = $this->resource->findOrFail($id);

		if( ! $resource->update(Input::all())) //to-do revisar si es buena idea usar input all
			return Redirect::back()->withInput()->withErrors($resource->getErrors());

		Session::flash('success', sprintf(_('%s successfully updated'), $resource));
		return Redirect::route("{$this->prefix}.show", $id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if($resource = $this->resource->find($id) and $resource->delete())
			Session::flash('success', sprintf(_('%s successfully deleted'), $resource));

		return Redirect::route("{$this->prefix}.index");
	}

	/**
	 * Extract the prefix from a resource controller route name.
	 *
	 * Trim the last segment from a route name.
	 * Optionally, append new segment $new_sufix.
	 *
	 * @param  string $route_name
	 * @param  string $new_sufix
	 * @return string
	 */
	protected function extractResourcePrefix($route_name, $new_sufix = null)
	{
		$segments = explode('.', $route_name);
		$segments = array_slice($segments, 0, count($segments) - 1);
		if( ! is_null($new_sufix))
			$segments[] = $new_sufix;

		return implode('.', $segments);
	}
}
