<?php

class AuthProvidersController extends BaseResourceController
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
	public function __construct(AuthProvider $resource)
	{
		parent::__construct($resource, $permissions = [
			'view'	 => Auth::user()->hasPermission(80),
			'add'	 => Auth::user()->hasPermission(81),
			'edit'	 => Auth::user()->hasPermission(82),
			'delete' => Auth::user()->hasPermission(83),
		]);

		// Relationships to eager load when listing resource
		$this->with = ['accounts'];
	}
}
