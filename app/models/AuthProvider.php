<?php

class AuthProvider extends BaseModel {

	protected $table = 'authproviders';
	protected $softDelete = true;
	protected $guarded = array('login_count', 'id', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('oauth2_id', 'oauth2_secret');

	// Meta ===================================================================

	public function singular() { return _('Auth. provider');}	// Singular form of this model's name
	public function plural() { return _('Auth. providers');}	// Singular name of this model's name
	public function __toString() { return $this->title;}

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|alpha_num|max:32|unique'],
			'title' => [_('Title'), 'required|max:32|unique'],
			'login_count' => [_('Login count'), 'integer|min:0'],
			'oauth2_id' => [_('App id'), 'max:255'],
			'oauth2_secret' => [_('App secret'), 'max:255'],
		));
	}

	// Relationships ==========================================================

	public function accounts()
	{
		return $this->hasMany('Account', 'provider_id');
	}

	// Logic ==================================================================

	/**
	 * Determine whether or not the model can be deleted.
	 *
	 * @param  boolean $throwExceptions
	 * @throws ModelDeletionException
	 * @return boolean
	 */
	public function deletable($throwExceptions = false)
	{
		// Prevent deleting Admin native account
		if($this->id == 1)
		{
			if($throwExceptions)
				throw new ModelDeletionException(sprintf(_('Deleting %s is not allowed'), $this));
			return false;
		}

		return true;
	}

	/**
	 * Search this model
	 *
	 * @param  string $query
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function search($query)
	{
		return Self::where('name', 'LIKE', "%$query%")->orWhere('title', 'LIKE', "%$query%")->orderBy('title')->get();
	}
}
