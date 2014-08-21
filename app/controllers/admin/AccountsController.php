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
		$user = Auth::user();

		$permissions = [
			// Resource
			'view'         => $user->hasPermission(100),
			'add'          => $user->hasPermission(101),
			'edit'         => $user->hasPermission(102),
			'delete'       => $user->hasPermission(103),
			// Relationships
			'viewProvider' => $user->hasPermission(80) and $this->with[] = 'provider',
			'viewUser'     => $user->hasPermission(10) and $this->with[] = 'user',
		];

		parent::__construct($resource, $permissions);
	}
}