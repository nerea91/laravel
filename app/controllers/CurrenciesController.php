<?php

class CurrenciesController extends BaseResourceController
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
	public function __construct(Currency $resource)
	{
		parent::__construct($resource, $permissions = [
			'view'	 => Auth::user()->hasPermission(120),
			'add'	 => Auth::user()->hasPermission(121),
			'edit'	 => Auth::user()->hasPermission(122),
			'delete' => Auth::user()->hasPermission(123),
		]);
	}
}
