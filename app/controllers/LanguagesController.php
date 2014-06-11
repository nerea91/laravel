<?php

class LanguagesController extends BaseResourceController
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
	public function __construct(Language $resource)
	{
		parent::__construct($resource, $permissions = [
			'view'	 => Auth::user()->hasPermission(20),
			'add'	 => Auth::user()->hasPermission(21),
			'edit'	 => Auth::user()->hasPermission(22),
			'delete' => Auth::user()->hasPermission(23),
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Eager load model with this relation
		return parent::index('users');
	}
}
