<?php

class AuthProvider extends BaseModel {

	protected $table = 'authproviders';
	protected $softDelete = true;
	protected $guarded = array('login_count', 'id', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('oauth2_id', 'oauth2_secret');

	// Meta ========================================================================

	/**
	 * Singular form of this model's name
	 *
	 * @return string
	 */
	public function singular()
	{
		return _('Auth. provider');
	}

	/**
	 * Plural form of this model's name
	 *
	 * @return string
	 */
	public function plural()
	{
		return _('Auth. providers');
	}

	/**
	 * What should be returned when this model is casted to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->title;
	}

	// Validation ==================================================================

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

	// Relationships ===============================================================

	public function accounts()
	{
		return $this->hasMany('Account', 'provider_id');
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Search this model
	 *
	 * @param  string $query
	 * @return Illuminate\Database\Eloquent\Collection (of AuthProvider)
	 */
	public static function search($query)
	{
		return self::where('name', 'LIKE', "%$query%")->orWhere('title', 'LIKE', "%$query%")->orderBy('title')->get();
	}

	// Logic =======================================================================

	/**
	 * Determine whether or not the model can be deleted.
	 *
	 * @param  boolean $throwExceptions
	 * @return boolean
	 *
	 * @throws ModelDeletionException
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
	 * Sort model by parameters given in the URL
	 * i.e: ?sortby=name&sortdir=desc
	 *
	 * @param Illuminate\Database\Eloquent\Builder
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOrderByUrl($query)
	{
		$column = Input::get('sortby');
		$direction = (Input::get('sortdir') == 'desc') ? 'desc' : 'asc';

		if($column == 'name')
			return $query->orderBy('title', $direction);

		return parent::scopeOrderByUrl($query);
	}

}
