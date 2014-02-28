<?php

class ProfilesController extends BaseResourceController {

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
	public function __construct(Profile $resource)
	{
		parent::__construct($resource, $permissions = [
			'view'	=> Auth::user()->hasPermission(40),
			'add'	=> Auth::user()->hasPermission(41),
			'edit'	=> Auth::user()->hasPermission(42),
			'delete'=> Auth::user()->hasPermission(43),
		]);

		$this->relationships = [
			'permissions' => [_('Permissions'), 'required|array|min:1'],
		];
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Eager load model with this relation
		return parent::index('users');
	}

}

//	// Make sure we are not duplicating profiles
//	elseif(false !== ($similar = Profile::existSimilar($permissions, $excluded_id)))
//	$this->resource->getErrors()->add('permissions', sprintf(_('Profile %s has exactly the same permissions'), $similar).'. '._('No duplicates allowed'));
