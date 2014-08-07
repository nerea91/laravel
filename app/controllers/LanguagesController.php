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
		$user = Auth::user();

		$permissions = [
			// Resource
			'view'     => $user->hasPermission(20),
			'add'      => $user->hasPermission(21),
			'edit'     => $user->hasPermission(22),
			'delete'   => $user->hasPermission(23),
			// Relationships
			'viewUser' => $user->hasPermission(10) and $this->with[] = 'users',
		];

		parent::__construct($resource, $permissions);
	}
}
