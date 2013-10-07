<?php

class PhonesController extends BaseController {

	/**
	 * Phone Repository
	 *
	 * @var Phone
	 */
	protected $phone;

	public function __construct(Phone $phone)
	{
		$this->phone = $phone;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$phones = $this->phone->all();

		return View::make('phones.index', compact('phones'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('phones.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Phone::$rules);

		if ($validation->passes())
		{
			$this->phone->create($input);

			return Redirect::route('phones.index');
		}

		return Redirect::route('phones.create')
			->withInput()
			->withErrors($validation)
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
		$phone = $this->phone->findOrFail($id);

		return View::make('phones.show', compact('phone'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$phone = $this->phone->find($id);

		if (is_null($phone))
		{
			return Redirect::route('phones.index');
		}

		return View::make('phones.edit', compact('phone'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Phone::$rules);

		if ($validation->passes())
		{
			$phone = $this->phone->find($id);
			$phone->update($input);

			return Redirect::route('phones.show', $id);
		}

		return Redirect::route('phones.edit', $id)
			->withInput()
			->withErrors($validation)
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
		$this->phone->find($id)->delete();

		return Redirect::route('phones.index');
	}

}
