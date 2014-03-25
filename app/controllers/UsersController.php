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
		// Eager load model with these relations
		return parent::index('profile', 'country');
	}

}
