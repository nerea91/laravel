<?php

class AuthProvider extends Stolz\Model {

	protected $softDelete = true;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('oauth2_secret');

	// Validation =============================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|alpha_num|max:32|unique'],
			'title' => [_('Name'), 'required|max:32|unique'],
			'logins_count' => [_('Name'), 'integer|min:0'],
			'oauth2_id' => [_('Name'), 'max:255'],
			'oauth2_secret' => [_('Name'), 'max:255'],
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
			//Prevent deleting Laravel Auth Provider
			if($model->id == 1)
				return false;
		});
	}

	// Logic ==================================================================
}
