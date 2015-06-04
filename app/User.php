<?php namespace App;

use App\Exceptions\ModelDeletionException;
use App\Exceptions\ModelValidationException;
use Auth;
use Cache;
use Crypt;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Input;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, SoftDeletes;

	protected $guarded = array('id', 'remember_token', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('password', 'password_confirmation', 'current_password', 'remember_token');

	// Meta ========================================================================

	/**
	 * Singular form of this model's name
	 *
	 * @return string
	 */
	public function singular()
	{
		return _('User');
	}

	/**
	 * Plural form of this model's name
	 *
	 * @return string
	 */
	public function plural()
	{
		return _('Users');
	}

	/**
	 * What should be returned when this model is casted to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->username;
	}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'username' => [_('Username'), 'required|min:4|max:32|regex:/^[a-zA-z]+[a-zA-z0-9]+$/|unique'],
			'name' => [_('Real name'), 'alpha_dash_space|max:64'],
			'description' => [_('Description'), 'max:128'],
			'password' => [_('Password'), 'required|min:5|max:60|different:username|confirmed'],
			'country_id' => [_('Country'), 'exists:countries,id'],
			'language_id' => [_('Language'), 'exists:languages,id'],
			'profile_id' => [_('Profile'), 'required|exists:profiles,id'],
		));
	}

	// Relationships ===============================================================

	public function accounts()
	{
		return $this->hasMany('App\Account');
	}

	public function country()
	{
		return $this->belongsTo('App\Country');
	}

	public function language()
	{
		return $this->belongsTo('App\Language');
	}

	public function options()
	{
		return $this->belongsToMany('App\Option')->withPivot('value');
	}

	public function profile()
	{
		return $this->belongsTo('App\Profile');
	}

	// Events ======================================================================

	public static function boot()
	{
		// NOTE saving   -> creating -> created   -> saved
		// NOTE saving   -> updating -> updated   -> saved
		// NOTE deleting -> deleted  -> restoring -> restored

		// updating BEFORE validation
		static::updating(function ($user) {
			// When updating, password is not required.
			if( ! strlen($user->convertEmptyAttributesToNull()->password))
			{
				$user->removeRule('password', 'required|confirmed');
				$user->restoreOriginalAttributes('password');
			}
		});

		// restoring BEFORE validation
		static::restoring(function ($user) {
			$user->removeRule('password', 'required|confirmed');
		});

		parent::boot(); // Validate the model

		static::saving(function ($user) {
			// Make sure profile is similar or inferior
			if(Auth::check() and Auth::user()->id !== 1 and ! Auth::user()->profile->getSimilarOrInferior()->contains($user->profile_id))
				throw new ModelValidationException(_('Profile must be similar or inferior to your own profile'));
		});

		static::creating(function ($user) {
			// Hash password if not hashed
			$user->hashPassword();
		});

		static::created(function ($user) {
			// If the user has no Laravel account, create it
			if( ! $user->accounts()->where('provider_id', 1)->first())
			{
				Account::create([
					'uid' => $user->id,
					'nickname' => $user->username,
					'name' => $user->name,
					'provider_id' => 1,
					'user_id' => $user->id,
				]);
			}
		});

		static::updating(function ($user) {
			// Hash password if not hashed
			$user->hashPassword();
		});

		static::updated(function ($user) {
			// If we have updated current user then change application language accordingly
			if(Auth::check() and Auth::user()->id == $user->id)
				$user->applyLanguage();
		});

		static::deleted(function ($user) {
			// Purge cache
			Cache::forget("adminSearchResults{$user->id}");
		});
	}

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Search this model
	 *
	 * @param  string $pattern
	 * @return \Illuminate\Database\Eloquent\Collection (of User)
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

			// In any other case search in all the relevant columns
			$query->orWhere('name', 'LIKE', "%$pattern%")->orWhere('username', 'LIKE', "%$pattern%")->orWhere('description', 'LIKE', "%$pattern%");

		})->orderBy('username')->get();
	}

	/**
	 * Create a new user with an automatillay generated username.
	 * If an $account is provided, the username will try to match the account personal info.
	 *
	 * @param  Account $account
	 * @return User
	 * @throws \Exception
	 */
	public static function autoCreate(Account $account = null)
	{
		// Profile of the user
		$profile = Profile::findOrFail(config('site.auto-registration-profile'));

		// Seeds for the username
		$seeds = ( ! $account) ? [] : array_filter([
			$account->first_name,
			$account->last_name,
			$account->name,
			$account->nickname,
			preg_replace('/([^@]*).*/', '$1', $account->email), //Username part of the email
			$account->first_name . str_random(4),
			$account->last_name . str_random(4),
			$account->name . str_random(4),
			$account->nickname . str_random(4),
			$account->provider->name . $account->uid,
		]);

		// Attempt to create user
		$user = new User([
			'username' => generate_username($seeds),
			'name' => ($account) ? $account->nameForHumans() : null,
			'password' => $password = str_random(60),
			'password_confirmation' => $password,
			'profile_id' => $profile->id,
		]);

		if( ! $user->save())
			throw new \Exception(_('Unable to create user'));

		return $user;
	}

	// AuthenticatableContract implementation ======================================

	// NOTE: The remaining methods from the contract are inplemented in the Authenticatable trait

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		// Avoid validation error when Illuminate\Auth\Guard tries to store remember_token
		$this->removeRule('password', 'required|confirmed');

		$this->{$this->getRememberTokenName()} = $value;
	}

	// CanResetPasswordContract implementation =====================================

	/**
	 * Get the e-mail address where password reset links are sent.
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function getEmailForPasswordReset()
	{
		// Get the email from the most recently updated account
		foreach($this->accounts()->orderBy('updated_at', 'desc')->get() as $account)
		{
			if( ! is_null($account->email))
				return $account->email;
		}

		throw new \Exception(_('No e-mail address found'));
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
		// Prevent deleting Admin user
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
	 * @param \Illuminate\Database\Eloquent\Builder
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOrderByUrl($query)
	{
		$column = Input::get('sortby');

		switch($column)
		{
			default:
				return parent::scopeOrderByUrl($query);

			case 'profile_id':
				$table = 'profiles';
				$relatedColumn = 'name';
				break;

			case 'country_id':
				$table = 'countries';
				$relatedColumn = 'name';
				break;
		}

		$direction = (Input::get('sortdir') === 'desc') ? 'desc' : 'asc';

		return $query
		->select($this->getTable().'.*') // Avoid 'ambiguous column name' for paginate() method
		->leftJoin($table, $column, '=', "$table.id") // Include related table
		->orderBy("$table.$relatedColumn", $direction); // Sort by related column
	}

	/**
	 * Check if user's profile has ALL of the provided permissions
	 *
	 * @param dynamic $permissions
	 * @return bool
	 */
	public function hasPermission($permissions)
	{
		// Unsaved users have no permissions
		if( ! $this->id)
			return false;

		$permissions = (is_array($permissions)) ? $permissions : func_get_args();

		return $this->profile->hasPermission($permissions);
	}

	/**
	 * Check if user's profile has ANY of the provided permissions
	 *
	 * @param dynamic $permissions
	 * @return bool
	 */
	public function hasAnyPermission($permissions)
	{
		// Unsaved users have no permissions
		if( ! $this->id)
			return false;

		$permissions = (is_array($permissions)) ? $permissions : func_get_args();

		return $this->profile->hasAnyPermission($permissions);
	}

	/**
	 * If user name is not null return it. Otherwise return username
	 *
	 * @return string
	 */
	public function name()
	{
		if(is_null($this->name))
			return $this->username;

		return $this->name;
	}

	/**
	 * Hash password if it's not hashed already
	 *
	 * @return User
	 */
	public function hashPassword()
	{
		if(Hash::needsRehash($this->password))
			$this->password = Hash::make($this->password);

		return $this;
	}

	/**
	 * Change application's language to $this user's language
	 *
	 * @return User
	 */
	public function applyLanguage()
	{
		if($this->language instanceof Language)
			$this->language->apply()->remember();

		return $this;
	}

	/**
	 * Get an user option by 'id' or 'name',
	 * Fallback to default if user does not have such option.
	 *
	 * @param  string
	 * @return string
	 *
	 * @thows Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function getOption($option)
	{
		if($userOption = $this->options()->where('options.id', $option)->orWhere('options.name', $option)->first())
			return $userOption->pivot->value;

		return Option::where('id', $option)->orWhere('name', $option)->firstOrFail()->value;
	}

	/**
	 * Get all user options.
	 * The missing user options are merged with the default ones
	 *
	 * @param  bool
	 * @return \Illuminate\Database\Eloquent\Collection (of Option)
	 */
	public function getOptions($onlyAssignable = false)
	{
		// Get default generic options
		$options = Option::all();

		// Get user options
		$userOptions = $this->options->each(function (&$o) {
			$o->value = $o->pivot->value;
			unset($o->pivot);
		});

		// Merge both (user options have priority)
		$options = $options->merge($userOptions);

		// Remove assignable?
		if($onlyAssignable)
		{
			$options = $options->filter(function ($o) {
				return $o->assignable;
			});
		}

		return $options;
	}

	/**
	 * Get all the assignable user options.
	 * The missing user options are merged with the default ones
	 *
	 * @return \Illuminate\Database\Eloquent\Collection (of Option)
	 */
	public function getAssignableOptions()
	{
		return $this->getOptions(true);
	}

	/**
	 * Change $this user options.
	 *
	 * @param  array
	 * @return \Illuminate\Support\MessageBag
	 */
	public function setOptions(array $options)
	{
		return Option::massAssignToUser($this, array_except($options, ['_method', '_token']));
	}

	/**
	 * Get user accounts from social providers.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection (of Account)
	 */
	public function getNonNativeAccounts()
	{
		// Determine if current request is HTTPs
		$secure = ( ! empty($_SERVER['HTTPS']) and $_SERVER['HTTPS'] !== 'off') or $_SERVER['SERVER_PORT'] == 443;

		$protocol = ($secure) ? 'https' : 'http';

		$accounts = $this->accounts()->where('provider_id', '<>', 1)->latest('updated_at')->with('provider')->get()->each(function ($account) use($protocol) {

			// Gravatar
			if( ! $account->image and $account->email)
				$account->image = $protocol . '://www.gravatar.com/avatar/' . md5($account->email);
		});

		return $accounts;
	}
}
