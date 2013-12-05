<?php

class UsersController extends BaseResourceController {

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
	public function __construct(User $resource)
	{
		parent::__construct($resource, $permissions = [
			'view'	=> Auth::user()->hasPermission(60),
			'add'	=> Auth::user()->hasPermission(61),
			'edit'	=> Auth::user()->hasPermission(62),
			'delete'=> Auth::user()->hasPermission(63),
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return parent::_index($this->resource->with('profile', 'country')->paginate());
	}







//
//	/**
//	 * Store a newly created resource in storage.
//	 *
//	 * @return Response
//	 */
//	public function store()
//	{
//		$this->resource = $this->resource->newInstance(Input::only('username', 'name', 'description', 'profile_id', 'country_id', 'language_id'));
//
//		// Validate and save
//		if( ! $this->validateCommon() or ! $this->resource->save())
//			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());
//
//		Session::flash('success', sprintf(_('User %s successfully created'), $this->resource->username));
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
//		$this->resource = $this->resource->findOrFail($id)->fill(Input::only('username', 'name', 'description', 'profile_id', 'country_id', 'language_id'));
//
//		// Validate and save
//		if( ! $this->validateCommon(false) or ! $this->resource->save())
//			return Redirect::back()->withInput()->withErrors($this->resource->getErrors());
//
//		Session::flash('success', sprintf(_('User %s successfully updated'), $this->resource->username));
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
//		if($this->resource->delete())
//			Session::flash('success', sprintf(_('User %s successfully deleted'), $this->resource->username));
//
//		return Redirect::route("{$this->prefix}.index");
//	}
//
//	/**
//	 * Common validation for $this->store() and $this->update()
//	 *
//	 * @param  boolean $require_password
//	 * @return boolean
//	 */
//	protected function validateCommon($require_password = true)
//	{
//		$password = Input::get('password');
//		$require_password = ($require_password or strlen($password)>0);
//
//		// Country is optional
//		if( ! intval($this->resource->country_id))
//			$this->resource->resetRule('country_id', 'exists')->country_id = null;
//
//		// Language is optional
//		if( ! intval($this->resource->language_id))
//			$this->resource->resetRule('language_id', 'exists')->language_id = null;
//
//		// Guarded attributes must be handled manually
//		if($require_password)
//		{
//			$this->resource->password = $password;
//			$this->resource->password_confirmation = Input::get('password_confirmation');
//		}
//		else
//			$this->resource->resetRule('password', 'required')->resetRule('password', 'confirmed');
//
//		// Validate
//		if( ! $this->resource->validate())
//			return false;
//
//		// We know the passwords are OK, remove the 'confirmed' rule
//		if($require_password)
//		{
//			$this->resource->password = Hash::make($this->resource->password);
//			$this->resource->resetRule('password', 'confirmed');
//		}
//
//		return true;
//	}
}
