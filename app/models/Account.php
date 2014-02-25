<?php

class Account extends BaseModel {

	protected $guarded = array('access_token', 'last_ip', 'login_count', 'id', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('access_token', 'last_ip');

	// Meta ===================================================================

	public function singular() { return _('Account');}	// Singular form of this model's name
	public function plural() { return _('Accounts');}	// Singular name of this model's name
	public function __toString() { return $this->user . ' (' . $this->provider . ')';}

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'uid' => [_('Remote id'), 'required|max:128'],
			'access_token' => [_('Access token'), null],
			'nickname' => [_('Nickname'), 'max:128'],
			'email' => [_('E-mail'), 'email|max:255'],
			'name' => [_('Name'), 'max:128'],
			'first_name' => [_('First name'), 'max:64'],
			'last_name' => [_('Last name'), 'max:64'],
			'image' => [_('Image'), 'max:255'],
			'locale' => [_('Locale'), 'max:5'],
			'location' => [_('Location'), 'max:128'],
			'login_count' => [_('Login count'), 'integer|min:0'],
			'last_ip' => [_('Last IP address'), null], // Could be 'ip' but as it's encrypt it will not validate
			'provider_id' => [_('Provider'), 'required|exists:authproviders,id'],
			'user_id' => [_('User'), 'required|exists:users,id'],
		));
	}

	// Relationships ==========================================================

	public function provider()
	{
		return $this->belongsTo('AuthProvider', 'provider_id');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	// Accessor / Mutators ===============================================

	/**
	 * IP Accessor
	 */
	public function getLastIpAttribute($value)
	{
		return ($value) ? Crypt::decrypt($value) : null;
	}

	/**
	 * IP Mutator
	 */
	public function setLastIpAttribute($value)
	{
		$value = trim($value);
		if(strlen($value))
			$this->attributes['last_ip'] = Crypt::encrypt($value);
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
		return Self::where('uid', 'LIKE', "%$query%")
		->orWhere('nickname', 'LIKE', "%$query%")
		->orWhere('email', 'LIKE', "%$query%")
		->orWhere('name', 'LIKE', "%$query%")
		->orWhere('first_name', 'LIKE', "%$query%")
		->orWhere('last_name', 'LIKE', "%$query%")
		->get();
	}

}
