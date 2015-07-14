<?php namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\ResourceController;
use App\User;

class CountriesController extends ResourceController
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
	public function __construct(Country $resource)
	{
		$user = (auth()->user()) ?: new User; // Fallback for `php artisan route:list` to work

		$permissions = [
			// Resource
			'view'         => $user->hasPermission(10),
			'add'          => $user->hasPermission(11),
			'edit'         => $user->hasPermission(12),
			'delete'       => $user->hasPermission(13),
			// Relationships
			'viewCurrency' => $user->hasPermission(120),
			'viewUser'     => $user->hasPermission(10) and $this->with[] = 'users',
		];

		parent::__construct($resource, $permissions);
	}
}
