<?php

class LanguagesController extends BaseController {

	/**
	 * Language Repository
	 *
	 * @var Language
	 */
	protected $language;

	public function __construct(Language $language)
	{
		$this->language = $language;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$languages = $this->language->all();

		return View::make('languages.index', compact('languages'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('languages.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->language = new Language(Input::all());

		if ($this->language->save())
			return Redirect::route('languages.index');

		return Redirect::route('languages.create')
		->withInput()
		->withErrors($this->language->getErrors())
		->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$language = $this->language->findOrFail($id);

		return View::make('languages.show', compact('language'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$language = $this->language->find($id);

		if (is_null($language))
		{
			return Redirect::route('languages.index');
		}

		return View::make('languages.edit', compact('language'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$language = $this->language->find($id);
		if ($language->update(array_except(Input::all(), '_method')))
			return Redirect::route('languages.show', $id);

		return Redirect::route('languages.edit', $id)
		->withInput()
		->withErrors($language->getErrors())
		->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->language->find($id)->delete();

		return Redirect::route('languages.index');
	}

}
