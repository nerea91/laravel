<?php

class AuthProvider extends Stolz\Database\Model {

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

	// Events ==================================================================

	public static function boot()
	{
		parent::boot();

		//NOTE Create events sequence: saving -> creating -> created -> saved
		//NOTE Update events sequence: saving -> updating -> updated -> saved

		static::deleting(function($model)
		{
			// Prevent deleting Laravel Auth Provider
			if($model->id == 1)
				return false;
		});
	}

	// Logic ==================================================================
}
