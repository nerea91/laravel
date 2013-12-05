<?php

class CountriesController extends BaseResourceController {

	/**
	 * The layout that should be used for responses.
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
		$user = Auth::user();
		parent::__construct($resource, $permissions = [
			'view'		=> $user->hasPermission(10),
			'add'		=> $user->hasPermission(11),
			'edit'		=> $user->hasPermission(12),
			'delete'	=> $user->hasPermission(13),
		]);
	}
}
