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
		$this->prefix = replace_last_segment(Route::currentRouteName());

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
		$return = replace_last_segment($this->prefix);

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
		$this->resource = $this->resource->findOrFail($id);
		$this->layout->subtitle = _('Details');
		return $this->load_view(__FUNCTION__, $this->resource->getVisibleLabels());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->subtitle = _('Add');
		return $this->load_view(__FUNCTION__, $this->resource->getFillableLabels());
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->resource = $this->resource->findOrFail($id);
		$this->layout->subtitle = _('Edit');
		return $this->load_view(__FUNCTION__, $this->resource->getFillableLabels());
	}

	/**
	 * Set layout title and load view.
	 *
	 * @param  string   $view
	 * @param  array    $labels
	 * @return Response
	 */
	protected function load_view($view, array $labels = null)
	{
		$data = [
			'resource'	=> $this->resource,
			'labels'	=> ($labels) ? (object) $labels : (object) $this->resource->getLabels(),
		];

		$this->layout->title = $this->resource->singular();
		$this->layout->content = View::make('resource.' . $view, $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->resource = $this->resource->fill(Input::all());

		return $this->persist(_('%s successfully created'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$this->resource = $this->resource->findOrFail($id)->fill(Input::all());

		return $this->persist(_('%s successfully updated'));
	}

	/**
	 * Persist resource to the data base.
	 *
	 * @param  string
	 * @return Response
	 */
	protected function persist($successMesssage)
	{
		if( ! $this->resource->save())
			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());

		Session::flash('success', sprintf($successMesssage, $this->resource));

		return Redirect::route("{$this->prefix}.show", $this->resource->getKey());
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

}
