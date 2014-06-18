<?php

use Illuminate\Database\Eloquent\Collection;

class Account extends BaseModel
{
	protected $guarded = array('access_token', 'last_ip', 'login_count', 'id', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('access_token', 'last_ip');

	// Meta ========================================================================

	/**
	 * Singular form of this model's name
	 *
	 * @return string
	 */
	public function singular()
	{
		return _('Account');
	}

	/**
	 * Plural form of this model's name
	 *
	 * @return string
	 */
	public function plural()
	{
		return _('Accounts');
	}

	/**
	 * What should be returned when this model is casted to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->user . ' (' . $this->provider . ')';
	}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'uid' => [_('Remote id'), 'required|max:128|unique_with:accounts,provider_id'],
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
			'last_ip' => [_('Last IP address'), null], // Could be 'ip' but as it's encrypt it would not validate
			'provider_id' => [_('Provider'), 'required|exists:authproviders,id'],
			'user_id' => [_('User'), 'required|exists:users,id|unique_with:accounts,provider_id'],
		));
	}

	// Relationships ===============================================================

	public function provider()
	{
		return $this->belongsTo('AuthProvider', 'provider_id')->withTrashed();
	}

	public function user()
	{
		return $this->belongsTo('User')->withTrashed();
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

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

	// Static Methods ==============================================================

	/**
	 * Search this model
	 *
	 * @param  string $query
	 * @return Collection (of Account)
	 */
	public static function search($query)
	{
		return self::where('uid', 'LIKE', "%$query%")
		->orWhere('nickname', 'LIKE', "%$query%")
		->orWhere('email', 'LIKE', "%$query%")
		->orWhere('name', 'LIKE', "%$query%")
		->orWhere('first_name', 'LIKE', "%$query%")
		->orWhere('last_name', 'LIKE', "%$query%")
		->orderBy('name')
		->orderBy('first_name')
		->orderBy('last_name')
		->get();
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

		switch($column)
		{
			default:
				return parent::scopeOrderByUrl($query);

			case 'user_id':
				$table = 'users';
				$relatedColumn = 'username';
				break;

			case 'provider_id':
				$table = 'authproviders';
				$relatedColumn = 'title';
				break;
		}

		$direction = (Input::get('sortdir') == 'desc') ? 'desc' : 'asc';

		return $query
		->select($this->getTable().'.*') // Avoid 'ambiguous column name' for paginate() method
		->leftJoin($table, $column, '=', "$table.id") // Include related table
		->orderBy("$table.$relatedColumn", $direction); // Sort by related column
	}
}
