<?php

class AuthProvider extends Stolz\Database\Model {

	protected $table = 'authproviders';
	protected $softDelete = true;
	protected $hidden = array('oauth2_secret');
	protected $guarded = array('oauth2_secret');

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
		return $this->hasMany('Account');
	}

	// Events ==================================================================

	public static function boot()
	{
		parent::boot();

		static::deleting(function($model)
		{
			// Prevent deleting Laravel Auth Provider
			if($model->id == 1)
				return false;
		});
	}

	// Logic ==================================================================
}
