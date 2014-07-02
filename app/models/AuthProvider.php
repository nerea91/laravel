<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use OAuth\Common\Service\AbstractService as OAuthService;

class AuthProvider extends BaseModel
{
	use SoftDeletingTrait;
	protected $table = 'authproviders';
	protected $guarded = array('login_count', 'id', 'created_at', 'updated_at', 'deleted_at');

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
		return (string) $this->title;
	}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|alpha_num|max:32|unique'],
			'title' => [_('Title'), 'required|max:32|unique'],
			'login_count' => [_('Login count'), 'integer|min:0'],
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
	 * @return Collection (of AuthProvider)
	 */
	public static function search($query)
	{
		return self::where('name', 'LIKE', "%$query%")->orWhere('title', 'LIKE', "%$query%")->orderBy('title')->get();
	}

	/**
	 * Get all usable providers.
	 *
	 * @return Collection (of AuthProvider)
	 */
	public static function getUsable()
	{
		return self::orderBy('title')->get()->filter(function ($provider) {
			return $provider->isUsable();
		});
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
		$direction = (Input::get('sortdir') === 'desc') ? 'desc' : 'asc';

		if($column === 'name')
			return $query->orderBy('title', $direction);

		return parent::scopeOrderByUrl($query);
	}

	/**
	 * Determine if provider is enabled and has been configured in app/config/services.php file.
	 *
	 * @return boolean
	 */
	public function isUsable()
	{
		if(
			$this->trashed() or
			empty($this->name) or
			empty(Config::get("services.{$this->name}.client_id")) or
			empty(Config::get("services.{$this->name}.client_secret"))
			)
			return false;

		return true;
	}

	/**
	 * Find the local account associated with a remote user.
	 * If no account is found create it.
	 *
	 * @param  \OAuth\Common\Service\AbstractService $service
	 * @return Account
	 */
	public function findOrCreateAccount(OAuthService $service)
	{
		// Make a new account with data provided by remote $service
		$newAccount = $this->makeAccountFromService($service);

		// If an account of $this provider already exists then reuse it
		if($oldAccount = Account::where(['provider_id' => $this->id, 'uid' => $newAccount->uid])->first())
			return $oldAccount->mergeMissingAttributes($newAccount);

		// If an account from different provider but same email exists then reuse its user
		if(Validator::make($newAccount->toArray(), ['email' => 'required|email'])->passes() and $oldAccount = Account::where('email', $newAccount->email)->first())
			$newAccount->user_id = $oldAccount->user_id;

		// Create account with transactions
		try
		{
			DB::beginTransaction();

			// Create new user
			if( ! $newAccount->user_id)
				$newAccount->user_id = User::autoCreate($newAccount)->id; // If something went wrong it will throw an exception

			// Save new account
			if( ! $newAccount->save())
				throw new Exception('Unable to create account');

			// Success :)
			DB::commit();
			return $newAccount;
		}
		catch(Exception $e)
		{
			DB::rollBack();
			throw $e; // Unexpected exception, re-throw it to be able to debug it.
		}
	}

	/**
	 * Make an account of $this provider with the data fetched from $service.
	 *
	 * @param  \OAuth\Common\Service\AbstractService $service
	 * @return Account
	 * @throws Exception
	 */
	public function makeAccountFromService(OAuthService $service)
	{
		switch($this->name)
		{
			case 'facebook':
				$data = json_decode($service->request('/me'), true);
				$account = Account::makeFromFacebook($data);
				break;

			case 'google':
				$data = json_decode($service->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
				$account = Account::makeFromGoogle($data);
				break;

			default:
				throw new Exception(sprintf('Provider %s has no account generator', $this));
		}

		$account->provider_id = $this->id;
		return $account;
	}
}
