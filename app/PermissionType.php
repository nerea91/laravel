<?php namespace App;

use Cache;

class PermissionType extends Model
{
	public $table = 'permissiontypes';
	public $timestamps = false;
	protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

	// Meta ========================================================================

	// Validation ==================================================================

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setRules([
			'name'        => [_('Name'), 'required|max:64|unique'],
			'description' => [_('Description'), 'nullable|max:255'],
		]);
	}

	// Relationships ===============================================================

	public function permissions()
	{
		return $this->hasMany('App\Permission', 'type_id');
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Get types with at least one permission.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection (of User)
	 */
	public static function inUse()
	{
		return self::has('permissions')->orderBy('name')->get();
	}

	// Logic =======================================================================
}
