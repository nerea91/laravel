<?php

class AccountsController extends BaseResourceController
{

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
			'view'	 => Auth::user()->hasPermission(100),
			'add'	 => Auth::user()->hasPermission(101),
			'edit'	 => Auth::user()->hasPermission(102),
			'delete' => Auth::user()->hasPermission(103),
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
		return parent::index('user', 'provider');
	}
}
