<?php

class Account extends Stolz\Database\Model {

	protected $guarded = array('access_token');
	protected $hidden = array('access_token');

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'uid' => [_('Unique id'), 'required|max:128'],
			'access_token' => [_('Access token'), 'required'],
			'nickname' => [_('Nickname'), 'max:128'],
			'email' => [_('E-mail'), 'email|max:255'],
			'name' => [_('Name'), 'max:128'],
			'first_name' => [_('First name'), 'max:64'],
			'last_name' => [_('Last name'), 'max:64'],
			'image' => [_('Image'), 'max:255'],
			'locale' => [_('Locale'), 'max:5'],
			'location' => [_('Location'), 'max:128'],
			'provider_id' => [_('Provider'), 'required|exists:authproviders'],
			'user_id' => [_('User'), 'required|exists:users'],
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

		static::deleting(function($model)
		{
			//Prevent deleting Superuser admin account
			if($model->id == 1)
				return false;
		});
	}

	// Logic ==================================================================
}
