<?php

class UsersController extends BaseController {

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layouts.admin';

	/**
	 * The common part of the name shared by all the routes of this controller.
	 */
	protected $prefix = 'admin.users';

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
		$this->resource = new User;

		View::share([
			'prefix'	=> $this->prefix,

			// Permissions
			'view'		=> Auth::user()->hasPermission(60),
			'add'		=> Auth::user()->hasPermission(61),
			'edit'		=> Auth::user()->hasPermission(62),
			'delete'	=> Auth::user()->hasPermission(63),
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
			'results'	=> $this->resource->with('profile', 'country')->paginate(),
			'labels'	=> (object) $this->resource->getLabels(),
		];

		if($data['results']->getTotal())
			Assets::add('responsive-tables');

		$this->layout->title = _('Users');
		$this->layout->subtitle = _('Index');
		$this->layout->content = View::make('admin.index', $data);
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
			'prompt'	=> 'username'
		];

		$this->layout->title = _('User');
		$this->layout->subtitle = _('Details');
		$this->layout->content = View::make('admin.show', $data);
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
		];

		$this->layout->title = _('User');
		$this->layout->subtitle = _('Add');
		$this->layout->content = View::make('admin.create', $data);
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
			'resource'	=> $this->resource->findOrFail($id)
		];

		$this->layout->title = _('User');
		$this->layout->subtitle = _('Edit');
		$this->layout->content = View::make('admin.edit', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->resource = $this->resource->newInstance(Input::only('username', 'name', 'description', 'profile_id', 'country_id', 'language_id'));

		// Validate and save
		if( ! $this->validateCommon() or ! $this->resource->save())
			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());

		Session::flash('success', sprintf(_('User %s successfully created'), $this->resource->username));
		return Redirect::route("{$this->prefix}.show", $this->resource->getKey());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$this->resource = $this->resource->findOrFail($id)->fill(Input::only('username', 'name', 'description', 'profile_id', 'country_id', 'language_id'));

		// Validate and save
		if( ! $this->validateCommon(false) or ! $this->resource->save())
			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());

		Session::flash('success', sprintf(_('User %s successfully updated'), $this->resource->username));
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
		$this->resource = $this->resource->findOrFail($id);

		if($this->resource->delete())
			Session::flash('success', sprintf(_('User %s successfully deleted'), $this->resource->username));

		return Redirect::route("{$this->prefix}.index");
	}

	/**
	 * Common validation for $this->store() and $this->update()
	 *
	 * @param  boolean $require_password
	 * @return boolean
	 */
	protected function validateCommon($require_password = true)
	{
		$password = Input::get('password');
		$require_password = ($require_password or strlen($password)>0);

		// Country is optional
		if( ! intval($this->resource->country_id))
			$this->resource->resetRule('country_id', 'exists')->country_id = null;

		// Language is optional
		if( ! intval($this->resource->language_id))
			$this->resource->resetRule('language_id', 'exists')->language_id = null;

		// Guarded attributes must be handled manually
		if($require_password)
		{
			$this->resource->password = $password;
			$this->resource->password_confirmation = Input::get('password_confirmation');
		}
		else
			$this->resource->resetRule('password', 'required')->resetRule('password', 'confirmed');

		// Validate
		if( ! $this->resource->validate())
			return false;

		// We know the passwords are OK, remove the 'confirmed' rule
		if($require_password)
		{
			$this->resource->password = Hash::make($this->resource->password);
			$this->resource->resetRule('password', 'confirmed');
		}

		return true;
	}
}
