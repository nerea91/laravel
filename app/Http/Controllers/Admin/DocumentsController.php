<?php namespace App\Http\Controllers\Admin;

use App\Document;
use App\Http\Controllers\ResourceController;
use App\User;

class DocumentsController extends ResourceController
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
	public function __construct(Document $resource)
	{
		$user = (auth()->user()) ?: new User; // Fallback for `php artisan route:list` to work

		$permissions = [
			// Resource
			'view'        => $user->hasPermission(140),
			'add'         => $user->hasPermission(141),
			'edit'        => $user->hasPermission(142),
			'delete'      => $user->hasPermission(143),
			// Relationships
			'viewProfile' => $user->hasPermission(40) and $this->with[] = 'profiles',
		];

		parent::__construct($resource, $permissions);

		// Relationships to validate when saving resource
		$this->relationships = [
			'profiles' => [_('Profiles'), 'required|array|min:1'],
		];
	}
}
