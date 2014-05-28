<?php

/**
 * Common part for all resource controllers.
 */

class BaseResourceController extends \BaseController
{

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
	 * Relationships of the resource.
	 * @var array
	 */
	protected $relationships = [];

	/**
	 * Class constructor
	 *
	 * @param  Model $resource An instance of the resource this controller is in charge of.
	 * @param  array $permissions Permissions passed to the views
	 * @return void
	 */
	public function __construct($resource, array $permissions = array())
	{
		// Enable CSRF filter
		parent::__construct();

		$this->resource = $resource;
		$this->prefix = replace_last_segment(Route::current()->getName());

		// Views require prefix to generate URLs and permissions to render buttons
		View::share(['prefix' => $this->prefix] + $permissions);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  array|string eager load model with these relations
	 * @return Response
	 */
	protected function index()
	{
		// Paginate resource resutls
		$results = $this->resource->orderByUrl()->with(func_get_args())->paginate();

		// If results found add asset to make tables responsive
		//$results->getTotal() and Assets::add('responsive-tables');

		// Create header links for sorting by column
		$links = (object) link_to_sort_by($this->resource->getVisibleLabels());

		// Set the route for the return button
		$return = replace_last_segment($this->prefix);

		$this->layout->title = $this->resource->plural();
		$this->layout->subtitle = _('Index');
		$this->layout->content = View::make('resource.index', compact('results', 'links', 'return'));
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
		return $this->loadView(__FUNCTION__, $this->resource->getVisibleLabels());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->subtitle = _('Add');
		return $this->loadView(__FUNCTION__, $this->resource->getFillableLabels());
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
		return $this->loadView(__FUNCTION__, $this->resource->getFillableLabels());
	}

	/**
	 * Set layout title and load view.
	 *
	 * @param  string   $view
	 * @param  array    $labels
	 * @return Response
	 */
	protected function loadView($view, array $labels = null)
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
		$input = Input::except(array_keys($this->relationships)); // Less safe, more convenient
		//$input = Input::only(array_keys($this->resource->getFillableLabels())); //More safe, less convenient
		$this->resource = $this->resource->fill($input);

		return $this->persist(__FUNCTION__);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// NOTE: If you override this method remember to exclude $this->relationships from input!!
		$input = Input::except(array_keys($this->relationships)); // Less safe, more convenient

		$this->resource = $this->resource->findOrFail($id)->fill($input);

		return $this->persist(__FUNCTION__);
	}

	/**
	 * Save resource to the data base using transactions.
	 *
	 * @param  string   $action
	 * @return Response
	 */
	protected function persist($action)
	{
		try
		{
			DB::beginTransaction();

			// Validate resource relationships
			if($this->relationships)
			{
				list($labels, $rules) = \Stolz\Validation\Validator::parseRules($this->relationships);
				$validator = Validator::make(Input::only(array_keys($rules)), $rules)->setAttributeNames($labels);
				if($validator->fails())
				{
					$this->resource->validate();
					$this->resource->getErrors()->merge($validator->messages()->toArray());
					throw new ModelValidationException(_('Wrong relationships data'));
				}
			}

			// Validate and save resource
			if( ! $this->resource->save())
				throw new ModelValidationException(_('Wrong data'));

			// Save resource relationships
			foreach($this->relationships as $relationship => $notUsed)
				$this->resource->$relationship()->sync(Input::get($relationship));

			// Success :)

			DB::commit();

			if($action == 'update')
				$successMesssage = _('%s successfully updated');
			elseif($action == 'store')
				$successMesssage = _('%s successfully created');
			else
				$successMesssage = _('%s successfully saved');

			Session::flash('success', sprintf($successMesssage, $this->resource));

			return Redirect::route("{$this->prefix}.show", $this->resource->getKey());
		}
		catch(Exception $e)
		{
			DB::rollBack();

			if($e instanceof ModelValidationException)
				Session::flash('error', $e->getMessage());
			else
				throw $e; // Unexpected exception, re-throw it to be able to debug it.

			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try
		{
			if($resource = $this->resource->find($id) and $resource->deletable(true) and $resource->delete())
				Session::flash('success', sprintf(_('%s successfully deleted'), $resource));

			$response = Redirect::route("{$this->prefix}.index");
		}
		catch(ModelDeletionException $e)
		{
			Session::flash('error', $e->getMessage());
			$response = Redirect::back();
		}

		return $response;
	}
}
