<?php

class Account extends Stolz\Database\Model {

	protected $guarded = array('access_token', 'id', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('access_token');

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

	// Events ==================================================================

	public static function boot()
	{
		parent::boot();

		//NOTE Create events sequence: saving -> creating -> created -> saved
		//NOTE Update events sequence: saving -> updating -> updated -> saved

		static::deleting(function($model)
		{
			// Prevent deleting Superuser admin account
			if($model->id == 1)
				return false;
		});
	}

	// Logic ==================================================================
}
