<?php

class CountriesController extends BaseResourceController {

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
	public function __construct(Country $resource)
	{
		parent::__construct($resource, $permissions = [
			'view'	=> Auth::user()->hasPermission(10),
			'add'	=> Auth::user()->hasPermission(11),
			'edit'	=> Auth::user()->hasPermission(12),
			'delete'=> Auth::user()->hasPermission(13),
		]);
	}

}
