<?php

class ProfilesController extends BaseController {

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layouts.admin';

	/**
	 * The common part of the name shared by all the routes of this controller.
	 */
	protected $prefix = 'admin.profiles';

	/**
	 * Instance of the resource that this controller is in charge of.
	 */
	protected $resource;

	/**
	 * Class constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->resource = new Profile;

		View::share([
			'prefix'	=> $this->prefix,

			//Permissions
			'view'		=> Auth::user()->hasPermission(40),
			'add'		=> Auth::user()->hasPermission(41),
			'edit'		=> Auth::user()->hasPermission(42),
			'delete'	=> Auth::user()->hasPermission(43),
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = [
			'results'	=> $this->resource->paginate(),
			'labels'	=> (object) $this->resource->getLabels(),
		];

		if($data['results']->getTotal())
			Assets::add('responsive-tables');

		$this->layout->title = _('Profiles');
		$this->layout->subtitle = _('Index');
		$this->layout->content = View::make('admin.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = [
			'resource'	=> new Profile(Input::all()),
			'types'		=> PermissionType::has('permissions')->orderBy('name')->get()->lists('name', 'id'), //to-do parar esto a uns cope para poder reusarlo en este mismo controalador
		];

		//Split permissions by type
		$permissions = array();
		Permission::orderBy('type_id')->orderBy('name')->get()->each(function($p) use (&$permissions)
		{
			$permissions[$p->type_id][$p->id] = $p->name;
		});
		$data['permissions'] = $permissions;

		$this->layout->title = _('Profile');
		$this->layout->subtitle = _('Add');
		$this->layout->content = View::make('admin.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$resource =  new Profile(Input::all());

		if( ! $resource->save())
			return Redirect::back()->withInput()->withErrors($resource->getErrors());

		Session::flash('success', sprintf(_('Profile %s successfully created'), $resource->name));
		return Redirect::route("{$this->prefix}.show", $resource->getKey());
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
			'labels'	=> $this->resource->getVisibleLabels(),
			'prompt'	=> 'name'
		];

		$this->layout->title = _('Profile');
		$this->layout->subtitle = _('Details');
		$this->layout->content = View::make('admin.show', $data);
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

		$this->layout->title = _('Profile');
		$this->layout->subtitle = _('Edit');
		$this->layout->content = View::make('admin.edit', $data);
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

		if( ! $resource->update(Input::all()))
			return Redirect::back()->withInput()->withErrors($resource->getErrors());

		Session::flash('success', sprintf(_('Profile %s successfully updated'), $resource->name));
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
			Session::flash('success', sprintf(_('Profile %s successfully deleted'), $resource->name));

		return Redirect::route("{$this->prefix}.index");
	}

}
