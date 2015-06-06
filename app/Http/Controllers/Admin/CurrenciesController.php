<?php namespace App\Http\Controllers\Admin;

use App\Currency;
use App\Http\Controllers\ResourceController;
use App\User;
use Auth;

class CurrenciesController extends ResourceController
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
	public function __construct(Currency $resource)
	{
		$user = (Auth::user()) ?: new User; // Fallback for `php artisan route:list` to work

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
