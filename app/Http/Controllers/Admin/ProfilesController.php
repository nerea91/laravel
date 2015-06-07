<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Profile;
use App\User;
use Auth;
use Cache;

class ProfilesController extends ResourceController
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
	public function __construct(Profile $resource)
	{
		$user = (Auth::user()) ?: new User; // Fallback for `php artisan route:list` to work

		$permissions = [
			// Resource
			'view'     => $user->hasPermission(40),
			'add'      => $user->hasPermission(41),
			'edit'     => $user->hasPermission(42),
			'delete'   => $user->hasPermission(43),
			// Relationships
			'viewUser' => $user->hasPermission(10) and $this->with[] = 'users',
		];

		parent::__construct($resource, $permissions);

		// Relationships to validate when saving resource
		$this->relationships = [
			'permissions' => [_('Permissions'), 'required|array|min:1'],
		];
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		// Purge permission cache
		Cache::forget('profile' . intval($id) . 'permissions');

		return parent::edit($id);
	}
}

// Make sure we are not duplicating profiles
// if(false !== ($similar = Profile::existSimilar($permissions, $excluded_id)))
// $this->resource->getErrors()->add('permissions', sprintf(_('Profile %s has exactly the same permissions'), $similar).'. '._('No duplicates allowed'));
