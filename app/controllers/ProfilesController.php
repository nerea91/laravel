<?php

class ProfilesController extends BaseResourceController {

	/**
	 * The layout that should be used for responses.
	 * @var string
	 */
	protected $layout = 'layouts.admin';

	/**
	 * Class constructor.
	 *
	 * @param  Model $resource Instance of the resource this controller is in charge of.
	 * @return void
	 */
	public function __construct(Profile $resource)
	{
		parent::__construct($resource, $permissions = [
			'view'	=> Auth::user()->hasPermission(40),
			'add'	=> Auth::user()->hasPermission(41),
			'edit'	=> Auth::user()->hasPermission(42),
			'delete'=> Auth::user()->hasPermission(43),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->relationships = [
			'permissions' => [_('Permissions'), 'required|array|min:1'],
		];

		return parent::store();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$this->relationships = [
			'permissions' => [_('Permissions'), 'required|array|min:1'],
		];
		
		return parent::update($id);
	}
}


//
//	/**
//	 * Show the form for creating a new resource.
//	 *
//	 * @return Response
//	 */
//	public function create()
//	{
//		$data = [
//			'resource'	=> $this->resource,
//			'types'		=> PermissionType::getUsed()->lists('name', 'id'),
//			'all'		=> Permission::getGroupedByType(),
//			'checked'	=> [], //Laravel will handle it
//		];
//
//		$this->layout->title = _('Profile');
//		$this->layout->subtitle = _('Add');
//		$this->layout->content = View::make('admin.create', $data);
//	}
//
//	/**
//	 * Show the form for editing the specified resource.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function edit($id)
//	{
//		$this->resource = $this->resource->findOrFail($id);
//
//		$data = [
//			'resource'	=> $this->resource,
//			'types'		=> PermissionType::getUsed()->lists('name', 'id'),
//			'all'		=> Permission::getGroupedByType(),
//			'checked'	=> $this->resource->permissions->lists('id'),
//		];
//		//to-do por un bug se marcan todos como checked cuando solo deberían marcarse los aqui indicados
//		//http://forums.laravel.io/viewtopic.php?pid=54313
//		//https://github.com/laravel/framework/issues/2548
//
//		$this->layout->title = _('Profile');
//		$this->layout->subtitle = _('Edit');
//		$this->layout->content = View::make('admin.edit', $data);
//	}
//
//	/**
//	 * Store a newly created resource in storage.
//	 *
//	 * @return Response
//	 */
//	public function store()
//	{
//		$this->resource = $this->resource->newInstance(Input::only('name', 'description'));
//
//		// Validate
//		if( ! $this->validateCommon($permissions = Input::get('permissions')))
//			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());
//
//		// Store
//		DB::transaction(function() use ($permissions)
//		{
//			$this->resource->save() and $this->resource->permissions()->attach($permissions);
//		});
//
//		// Success
//		Session::flash('success', sprintf(_('Profile %s successfully created with %d permissions'), $this->resource->name, count($permissions)));
//		return Redirect::route("{$this->prefix}.show", $this->resource->getKey());
//	}
//
//	/**
//	 * Update the specified resource in storage.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function update($id)
//	{
//		$this->resource = $this->resource->findOrFail($id)->fill(Input::only('name', 'description'));
//
//		// Validate
//		if( ! $this->validateCommon($permissions = Input::get('permissions'), $id))
//			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());
//
//		// Update
//		DB::transaction(function() use ($permissions)
//		{
//			$this->resource->save() and $this->resource->permissions()->sync($permissions);
//			// Changes in pivot tables don't fire events in models so we fire it manually to purge permissions cache
//			$this->resource->fireEvent('updated');
//		});
//
//		// Success
//		Session::flash('success', sprintf(_('Profile %s successfully created with %d permissions'), $this->resource->name, count($permissions)));
//		return Redirect::route("{$this->prefix}.show", $id);
//	}
//
//	/**
//	 * Remove the specified resource from storage.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function destroy($id)
//	{
//		$this->resource = $this->resource->findOrFail($id);
//
//		// Check if profile is us use
//		if($users = $this->resource->getUsernamesArray())
//			return Redirect::back()->withInput()->withError(sprintf(_('Profile cannot be deleted because it is still assigned to %s'), implode(', ', $users)));
//
//		if($this->resource->delete())
//			Session::flash('success', sprintf(_('Profile %s successfully deleted'), $this->resource->name));
//
//		return Redirect::route("{$this->prefix}.index");
//	}
//
//	/**
//	 * Common validation for $this->store() and $this->update()
//	 *
//	 * @param  array $permissions
//	 * @param  integer $excluded_id
//	 * @return boolean
//	 */
//	protected function validateCommon($permissions, $excluded_id = null)
//	{
//		$this->resource->validate();
//
//		// Make sure we get an array even if no permissions are checked
//		$permissions = (array) $permissions;
//
//		// Make sure at least one permission has been selected
//		if( ! $count = count($permissions))
//			$this->resource->getErrors()->add('permissions', _('Profile must have at least one permission'));
//
//		// Make sure all the provided permissions actually exist in the data base
//		elseif($count != Permission::whereIn('id', $permissions)->get()->count())
//			$this->resource->getErrors()->add('permissions', _('Some of the provided permission were not recognized'));
//
//		// Make sure we are not duplicating profiles
//		elseif(false !== ($similar = Profile::existSimilar($permissions, $excluded_id)))
//			$this->resource->getErrors()->add('permissions', sprintf(_('Profile %s has exactly the same permissions'), $similar).'. '._('No duplicates allowed'));
//
//		return ! $this->resource->hasErrors();
//	}
