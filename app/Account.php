<?php namespace App;

use App\Exceptions\ModelDeletionException;
use Crypt;
use Hash;
use Input;

class Account extends Model
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
		return (string) $this->user . ' (' . $this->provider . ')';
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
		return $this->belongsTo('App\AuthProvider', 'provider_id')->withTrashed();
	}

	public function user()
	{
		return $this->belongsTo('App\User')->withTrashed();
	}

	// Events ======================================================================

	public static function boot()
	{
		// NOTE saving   -> creating -> created   -> saved
		// NOTE saving   -> updating -> updated   -> saved
		// NOTE deleting -> deleted  -> restoring -> restored

		// updating BEFORE validation
		static::updating(function ($account) {
			// Updating user or provider is not allowed
			$account->restoreOriginalAttributes('provider_id', 'user_id');
		});

		parent::boot(); // Validate the model
	}

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
	 * @param  string $pattern
	 * @return Illuminate\Database\Eloquent\Collection (of Account)
	 */
	public static function search($pattern)
	{
		// Apply parameter grouping http://laravel.com/docs/queries#advanced-wheres
		return self::where(function($query) use ($pattern) {

			// If pattern is a number search in the numeric columns
			if(is_numeric($pattern))
				$query->orWhere('id', $pattern);

			// If pattern looks like a date search in the datetime columns
			if(preg_match('/^\d{4}-[01]\d-[0-3]\d$/', $pattern))
				$query->orWhereRaw('DATE(created_at) = ?', [$pattern]);

			// If pattern looks like an email address
			if(strlen($pattern) > 5 and strpos($pattern, '@'))
				$query->orWhere('email', 'LIKE', "%$pattern%");

			// In any other case search in all the relevant columns
			$query->orWhere('uid', 'LIKE', "%$pattern%")
			->orWhere('nickname', 'LIKE', "%$pattern%")
			->orWhere('name', 'LIKE', "%$pattern%")
			->orWhere('first_name', 'LIKE', "%$pattern%")
			->orWhere('last_name', 'LIKE', "%$pattern%")
			->orWhere('location', 'LIKE', "%$pattern%");

		})->orderBy('name')->orderBy('first_name')->orderBy('last_name')->orderBy('email')->get();
	}

	/**
	 * Make a new account filled with data provided by Facebook.
	 *
	 * @param  \Laravel\Socialite\AbstractUser $user
	 * @return Account
	 */
	public static function makeFromFacebook(\Laravel\Socialite\AbstractUser $user)
	{
		/* Example of Facebook $user:
			[token] => 'xxxYYYYzzzzzzWWWWW'
			[id] => '12345'
			[nickname] => null
			[name] => 'John Doe'
			[email] => 'john@example.com'
			[avatar] => 'https://graph.facebook.com/12345/picture?type=normal'
			[user] => array (
				[id] => '12345'
				[email] => 'john@example.com'
				[first_name] => 'John'
				[gender] => 'male'
				[last_name] => 'Doe'
				[link] => 'https://www.facebook.com/app_scoped_user_id/12345/'
				[locale] => 'en_US'
				[name] => 'John Doe'
				[timezone] => 2
				[updated_time] => '2012-07-17T17:26:49+0000'
				[verified] => true
			)
		*/

		$account = new Account([
			'uid'          => $user->id,
			'access_token' => Hash::make($user->token),
			'nickname'     => (isset($user->nickname)) ? $user->nickname : null,
			'email'        => (isset($user->email) and isset($user->user['verified']) and $user->user['verified'] === true) ? $user->email : null,
			'name'         => (isset($user->name)) ? $user->name : null,
			'first_name'   => (isset($user->user['first_name'])) ? $user->user['first_name'] : null,
			'last_name'    => (isset($user->user['last_name'])) ? $user->user['last_name'] : null,
			'image'        => (isset($user->avatar)) ? $user->avatar : null,
			'locale'       => (isset($user->user['locale'])) ? $user->user['locale'] : null,
			//'location'     => null,
		]);

		return $account;
	}

	/**
	 * Make a new account filled with data provided by Google.
	 *
	 * @param  \Laravel\Socialite\AbstractUser $user
	 * @return Account
	 */
	public static function makeFromGoogle(\Laravel\Socialite\AbstractUser $user)
	{
		$account = new Account;

		// Map between local and remote field names
		$map = [
			'uid'		=> 'id',
			//'nickname'=> '',
			'email'		=> 'email',
			'name'		=> 'name',
			'first_name' => 'given_name',
			'last_name'	=> 'family_name',
			'image'		=> 'picture',
			'locale'	=> 'locale',
			//'location'=> '',
		];

		// Fill
		foreach($map as $local => $remote)
			if(isset($user[$remote]))
				$account->$local = $user[$remote];

		// Don't trust unverified email
		if( ! isset($user['verified_email']) or $user['verified_email'] !== true)
			$account->email = null;

		return $account;
	}

	// Logic =======================================================================

	/**
	 * Determine whether or not the model can be deleted.
	 *
	 * @param  boolean $throwExceptions
	 * @return boolean
	 *
	 * @throws \App\Exceptions\ModelDeletionException
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

		$direction = (Input::get('sortdir') === 'desc') ? 'desc' : 'asc';

		return $query
		->select($this->getTable().'.*') // Avoid 'ambiguous column name' for paginate() method
		->leftJoin($table, $column, '=', "$table.id") // Include related table
		->orderBy("$table.$relatedColumn", $direction); // Sort by related column
	}

	/**
	 * Return the most human readable name the account has.
	 *
	 * @return string|null
	 */
	public function nameForHumans()
	{
		foreach(['first_name', 'name', 'last_name', 'nickname'] as $field)
			if( ! empty($this->$field))
				return $this->$field;

		return null;
	}

	/**
	 * Add the fields from $account that are not present on $this account.
	 *
	 * The fields provided in $foreceUpdateOnTheseFields will be replaced
	 * even if they were not empty.
	 *
	 * @param  Account $account
	 * @param  array   $foreceUpdateOnThisFields
	 * @return Account
	 */
	public function mergeMissingAttributes(Account $account, array $foreceUpdateOnTheseFields = [])
	{
		$fields = array_except(
			array_keys($this->getRules()),
			['uid', 'login_count', 'last_ip', 'provider_id', 'user_id', 'created_at', 'updated_at']
		);

		// Add fields that were empty
		foreach($fields as $field)
		{
			if(empty($this->$field))
				$this->$field = $account->$field;
		}

		// Add forced fields
		foreach($foreceUpdateOnTheseFields as $field)
			$this->$field = $account->$field;

		return $this;
	}
}
