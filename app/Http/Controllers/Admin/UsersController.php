<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\User;
use Auth;

class UsersController extends ResourceController
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
	public function __construct(User $resource)
	{
		$user = Auth::user();

		$permissions = [
			// Resource
			'view'         => $user->hasPermission(60),
			'add'          => $user->hasPermission(61),
			'edit'         => $user->hasPermission(62),
			'delete'       => $user->hasPermission(63),
			// Relationships
			'viewAccount'  => $user->hasPermission(100),
			'viewCountry'  => $user->hasPermission(10) and $this->with[] = 'country',
			'viewLanguage' => $user->hasPermission(20),
			'viewProfile'  => $user->hasPermission(40) and $this->with[] = 'profile',
		];

		parent::__construct($resource, $permissions);
	}
}
