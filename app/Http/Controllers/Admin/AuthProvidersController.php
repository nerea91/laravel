<?php namespace App\Http\Controllers\Admin;

use App\AuthProvider;
use App\Http\Controllers\ResourceController;
use App\User;

class AuthProvidersController extends ResourceController
{
	/**
	 * The layout that should be used for responses.
	 * @var string
	 */
	protected $layout = 'layouts.admin';

	/**
	 * Class constructor.
	 *
	 * @param  App\Model $resource Instance of the resource this controller is in charge of.
	 *
	 * @return void
	 */
	public function __construct(AuthProvider $resource)
	{
		$user = (auth()->user()) ?: new User; // Fallback for `php artisan route:list` to work

		$permissions = [
			// Resource
			'view'        => $user->hasPermission(80),
			'add'         => $user->hasPermission(81),
			'edit'        => $user->hasPermission(82),
			'delete'      => $user->hasPermission(83),
			// Relationships
			'viewAccount' => $user->hasPermission(100) and $this->with[] = 'accounts',
		];

		parent::__construct($resource, $permissions);
	}
}
