<?php

class ProfilesController extends BaseController {

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layouts.scaffold';

	/**
	 * Profile Repository
	 *
	 * @var Profile
	 */
	protected $profile;

	/**
	 * Constructor with dependency injection
	 *
	 * @param  Profile
	 * @return void
	 */
	public function __construct(Profile $profile)
	{
		$this->profile = $profile;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$profiles = $this->profile->all();
		$this->layout->title = _('Profiles');
		$this->layout->content = View::make('profiles.index', compact('profiles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->title = _('Add profile');
		$this->layout->content = View::make('profiles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$profile = Profile::create(Input::all());

		if ($profile->hasErrors())
			return Redirect::back()->withInput()->withErrors($profile->getErrors());

		return Redirect::route('profiles.index')->withSuccess(sprintf(_("Profile '%s' has been added"), $profile->name));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$profile = $this->profile->findOrFail($id);
		$this->layout->title = _('View profile');
		$this->layout->content = View::make('profiles.show', compact('profile'));
	}

	/**
		* Show the form for editing the specified resource.
		*
		* @param  int  $id
		* @return Response
		*/
	public function edit($id)
	{
		$profile = $this->profile->find($id);

		if (is_null($profile))
		{
			return Redirect::route('profiles.index');
		}

		$this->layout->title = sprintf(_("Edit profile '%s'"), $profile->name);
		$this->layout->content = View::make('profiles.edit', compact('profile'));
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
		$validation = Validator::make($input, Profile::$rules);

		if ($validation->passes())
		{
			$profile = $this->profile->find($id);
			$profile->update($input);

			return Redirect::route('profiles.show', $id);
		}

		return Redirect::route('profiles.edit', $id)
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
		$this->profile->find($id)->delete();

		return Redirect::route('profiles.index');
	}

}
