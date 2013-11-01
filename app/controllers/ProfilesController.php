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
			'resource'	=> $this->resource,
			'types'		=> PermissionType::getUsed()->lists('name', 'id'),
			'all'		=> Permission::getGroupedByType(),
			'checked'	=> [], //Laravel will handle it
		];

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
		$this->resource = $this->resource->newInstance(Input::only('name', 'description'));
		$this->resource->validate();
		$this->validatePermissions($permissions = Input::get('permissions'));

		if($this->resource->hasErrors())
			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());

		DB::transaction(function() use ($permissions)
		{
			$this->resource->save() and $this->resource->permissions()->attach($permissions);
		});

		Session::flash('success', sprintf(_('Profile %s successfully created with %d permissions'), $this->resource->name, count($permissions)));
		return Redirect::route("{$this->prefix}.show", $this->resource->getKey());
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
		$data = [
			'resource'	=> $this->resource,
			'prompt'	=> 'name',
			'permissions' => $this->resource->getPermissionsGroupedByType(true),
			'users'		=> $this->resource->users()->orderBy('username')->lists('username')
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
		$this->resource = $this->resource->findOrFail($id);

		$data = [
			'resource'	=> $this->resource,
			'types'		=> PermissionType::getUsed()->lists('name', 'id'),
			'all'		=> Permission::getGroupedByType(),
			'checked'	=> $this->resource->permissions->lists('id'),
		];
		//to-do por un bug se marcan todos como checked cuando solo deberían marcarse los aui indicados
		//http://forums.laravel.io/viewtopic.php?pid=54313
		//https://github.com/laravel/framework/issues/2548

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
		$this->resource = $this->resource->findOrFail($id);
		$this->resource->validate();
		$this->validatePermissions($permissions = Input::get('permissions'), $id);

		if($this->resource->hasErrors())
			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());

		DB::transaction(function() use ($permissions)
		{
			$this->resource->save() and $this->resource->permissions()->sync($permissions);
			//Changes in pivot tables don't fire events in models so we fire it manually to purge permissions cache
			$this->resource->fireEvent('updated');
		});

		Session::flash('success', sprintf(_('Profile %s successfully created with %d permissions'), $this->resource->name, count($permissions)));
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
			Session::flash('success', sprintf(_('Profile %s successfully deleted'), $resource->name));

		return Redirect::route("{$this->prefix}.index");
	}

	/**
	 * Common validation fro store() and update()
	 *
	 * @param  array $permissions
	 * @param  integer $excluded_id
	 * @return void
	 */
	protected function validatePermissions($permissions, $excluded_id = null)
	{
		$permissions = (array) $permissions;
		//Make sure at least one permission has been selected
		if( ! $count = count($permissions))
			$this->resource->getErrors()->add('permissions', _('Profile must have at least one permission'));

		//Make sure all the provided permissions actually exist
		elseif($count != Permission::whereIn('id', $permissions)->get()->count())
			$this->resource->getErrors()->add('permissions', _('Some of the provided permission were not recognized'));

		//Make sure there is no similar profile
		elseif(false !== ($similar = Profile::existSimilar($permissions, $excluded_id)))
			$this->resource->getErrors()->add('permissions', sprintf(_('Profile %s has exactly the same permissions'), $similar).'. '._('No duplicates allowed'));
	}

}
