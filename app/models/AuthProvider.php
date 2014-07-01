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

	/**
	 * Find the local account associated with a remote user.
	 * If no account is found create it.
	 *
	 * @param  \OAuth\Common\Service\AbstractService $service
	 * @return Account
	 */
	public function findOrCreateAccount(OAuthService $service)
	{
		// Fetch user information from remote service
		$userInfo = $this->fetchRemoteUserInfo($service);

		// Create an empty account and fill it with the remote data
		$newAccount = new Account($userInfo);

		// If an account of $this provider already exists then return it
		if($oldAccount = Account::where(['provider_id' => $this->id, 'uid' => $newAccount->uid])->first())
		{
			return $oldAccount; //to-do volver a rellenar los datos de $oldAccount que no esten en $newAccount
		}

		// New account must be created

		// If there is an account from different provider but same email, associate the new account with the same user as the existing account
		$validator = Validator::make($newAccount->toArray(), ['email' => 'required|email']);
		if($validator->passes() and $oldAccount = Account::where('email', $newAccount->email)->first())
			$newAccount->user_id = $oldAccount->user_id;

		// Create account (and user) with transactions
		try
		{
			DB::beginTransaction();

			// Create new user
			if( ! $newAccount->user_id)
			{
				$user = User::create(); //to-do comprobar que ha tenido exito
				$newAccount->user_id = $user->id;
			}

			// Save new account
			$newAccount->provider_id = $this->id;
			$newAccount->save(); // to-do comprobar que ha tenido exito

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
	 * Fetch user information from a remote service.
	 *
	 * @param  \OAuth\Common\Service\AbstractService $service
	 * @return array
	 * @throws Exception
	 */
	public function fetchRemoteUserInfo(OAuthService $service)
	{
		switch($this->name)
		{
			case 'facebook':
				$data = json_decode($service->request('/me'), true);
				$account = Account::fillFromFacebook($data);
				break;

			default:
				throw new Exception(sprintf('Provider %s has no Oauth fetcher', $this));
		}

		return $account->toArray();
	}
}
