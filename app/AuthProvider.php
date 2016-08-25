<?php namespace App;

use App\Exceptions\ModelDeletionException;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Input;
use Validator;

class AuthProvider extends Model
{
	use SoftDeletes;
	protected $table = 'authproviders';
	protected $guarded = ['login_count', 'id', 'created_at', 'updated_at', 'deleted_at'];

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

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->setRules([
			'name'        => [_('Name'), 'required|alpha_num|max:32|unique'],
			'title'       => [_('Title'), 'required|max:32|unique'],
			'login_count' => [_('Login count'), 'nullable|integer|min:0'],
		]);
	}

	// Relationships ===============================================================

	public function accounts()
	{
		return $this->hasMany('App\Account', 'provider_id');
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Search this model
	 *
	 * @param  string $pattern
	 *
	 * @return \Illuminate\Database\Eloquent\Collection (of AuthProvider)
	 */
	public static function search($pattern)
	{
		// Apply parameter grouping http://laravel.com/docs/queries#advanced-wheres
		return self::where(function ($query) use ($pattern) {

			// If pattern is a number search in the numeric columns
			if(is_numeric($pattern))
				$query->orWhere('id', $pattern);

			// If pattern looks like a date search in the datetime columns
			if(preg_match('/^\d{4}-[01]\d-[0-3]\d$/', $pattern))
				$query->orWhereRaw('DATE(created_at) = ?', [$pattern]);

			// In any other case search in all the relevant columns
			$query->orWhere('name', 'LIKE', "%$pattern%")->orWhere('title', 'LIKE', "%$pattern%");

		})->orderBy('title')->get();
	}

	/**
	 * Get all usable providers.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection (of AuthProvider)
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
	 *
	 * @return boolean
	 *
	 * @throws \App\Exceptions\ModelDeletionException
	 */
	public function deletable($throwExceptions = false)
	{
		// Prevent deleting Admin native account
		if($this->id != 1)
			return true;

		if($throwExceptions)
			throw new ModelDeletionException(sprintf(_('Deleting %s is not allowed'), $this));

		return false;
	}

	/**
	 * Sort model by parameters given in the URL
	 * i.e: ?sortby=name&sortdir=desc
	 *
	 * @param \Illuminate\Database\Eloquent\Builder
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
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
		// Check database fields
		if( ! $this->getKey() or $this->trashed() or empty($this->name))
			return false;

		// Check config
		$config = config("services.{$this->name}.client_id", config("services.{$this->name}.client_secret"));

		return ( ! empty($config));
	}

	/**
	 * Find the local account associated with a remote user.
	 *
	 * If no account is found it will create it.
	 *
	 * @param  \Laravel\Socialite\Contracts\User $user
	 *
	 * @return Account
	 * @throws Exceptions\OauthException
	 */
	public function findOrCreateAccount(\Laravel\Socialite\Contracts\User $user)
	{
		// Check if there is a method to generate accounts of $this provider
		$factory = 'makeFrom' . ucfirst($this->name);
		if( ! method_exists('\App\Account', $factory))
			throw new Exceptions\OauthException(sprintf('Provider %s has no account generator', $this));

		// Make a new account of $this provider with received $user data
		$newAccount = Account::$factory($user);
		$newAccount->provider_id = $this->id;

		// If an account of $this provider already exists then reuse it
		if($oldAccount = Account::where(['provider_id' => $this->id, 'uid' => $newAccount->uid])->first())
			return $oldAccount->mergeMissingAttributes($newAccount, ['access_token']);

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
				throw new \Exception('Unable to create account');

			// Success :)
			DB::commit();

			return $newAccount;
		}
		catch(\Exception $e)
		{
			DB::rollBack();
			throw $e; // Unexpected exception, re-throw it to be able to debug it.
		}
	}
}
