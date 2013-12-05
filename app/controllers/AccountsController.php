<?php

class AccountsController extends BaseResourceController {

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
	public function __construct(Account $resource)
	{
		parent::__construct($resource, $permissions = [
			'view'	=> Auth::user()->hasPermission(100),
			'add'	=> Auth::user()->hasPermission(101),
			'edit'	=> Auth::user()->hasPermission(102),
			'delete'=> Auth::user()->hasPermission(103),
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return parent::_index($this->resource->with('user', 'provider')->paginate());
	}

}



//
//	/**
//	 * Store a newly created resource in storage.
//	 *
//	 * @return Response
//	 */
//	public function store()
//	{
//		$resource =  new Account(Input::all());
//
//		if( ! $resource->save())
//			return Redirect::back()->withInput()->withErrors($resource->getErrors());
//
//		Session::flash('success', sprintf(_('Account %s successfully created'), $resource->name));
//		return Redirect::route("{$this->prefix}.show", $resource->getKey());
//	}
//
//	/**
//	 * Display the specified resource.
//	 *
//	 * @param  int  $id
//	 * @return Response
//	 */
//	public function show($id)
//	{
//		$data = [
//			'resource'	=> $this->resource->findOrFail($id),
//			'labels'	=> $this->resource->getVisibleLabels(),
//			'prompt'	=> 'name'
//		];
//
//		$this->layout->title = _('Account');
//		$this->layout->subtitle = _('Details');
//		$this->layout->content = View::make('admin.show', $data);
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
//		$data = [
//			'resource'	=> $this->resource->findOrFail($id),
//			'labels'	=> $this->resource->getFillableLabels(),
//		];
//
//		$this->layout->title = _('Account');
//		$this->layout->subtitle = _('Edit');
//		$this->layout->content = View::make('admin.edit', $data);
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
//		$resource = $this->resource->findOrFail($id);
//
//		if( ! $resource->update(Input::all()))
//			return Redirect::back()->withInput()->withErrors($resource->getErrors());
//
//		Session::flash('success', sprintf(_('Account %s successfully updated'), $resource->name));
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
//		if($resource = $this->resource->find($id) and $resource->delete())
//			Session::flash('success', sprintf(_('Account %s successfully deleted'), $resource->name));
//
//		return Redirect::route("{$this->prefix}.index");
//	}

