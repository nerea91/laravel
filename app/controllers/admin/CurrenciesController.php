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
		$user = Auth::user();

		$permissions = [
			// Resource
			'view'        => $user->hasPermission(120),
			'add'         => $user->hasPermission(121),
			'edit'        => $user->hasPermission(122),
			'delete'      => $user->hasPermission(123),
			// Relationships
			'viewCountry' => $user->hasPermission(10),
		];

		parent::__construct($resource, $permissions);
	}
}