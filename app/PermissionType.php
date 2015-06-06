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
			'description' => [_('Description'), 'max:255'],
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

	// Logic =======================================================================

	/**
	 * Get types with at least one permission.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeUsed($query)
	{
		return Cache::remember('usedPermissionTypes', 60 * 24, function () {
			return self::has('permissions')->orderBy('name')->get();
		});
	}
}
