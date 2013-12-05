<?php

class CurrenciesController extends BaseResourceController {

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
	public function __construct(Currency $resource)
	{
		parent::__construct($resource, $permissions = [
			'view'	=> Auth::user()->hasPermission(120),
			'add'	=> Auth::user()->hasPermission(121),
			'edit'	=> Auth::user()->hasPermission(122),
			'delete'=> Auth::user()->hasPermission(123),
		]);
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
//			'resource'	=> new Currency(Input::all()),
//			'labels'	=> $this->resource->getFillableLabels(),
//		];
//
//		$this->layout->title = _('Currency');
//		$this->layout->subtitle = _('Add');
//		$this->layout->content = View::make('admin.create', $data);
//	}
//
//	/**
//	 * Store a newly created resource in storage.
//	 *
//	 * @return Response
//	 */
//	public function store()
//	{
//		$resource =  new Currency(Input::all());
//
//		if( ! $resource->save())
//			return Redirect::back()->withInput()->withErrors($resource->getErrors());
//
//		Session::flash('success', sprintf(_('Currency %s successfully created'), $resource->code));
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
//			'prompt'	=> 'code'
//		];
//
//		$this->layout->title = _('Currency');
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
//		$this->layout->title = _('Currency');
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
//		Session::flash('success', sprintf(_('Currency %s successfully updated'), $resource->code));
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
//			Session::flash('success', sprintf(_('Currency %s successfully deleted'), $resource->code));
//
//		return Redirect::route("{$this->prefix}.index");
//	}

