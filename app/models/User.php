<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends BaseModel implements UserInterface, RemindableInterface
{
	use SoftDeletingTrait;
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('password', 'password_confirmation', 'current_password');

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
		return $this->hasMany('Account');
	}

	public function country()
	{
		return $this->belongsTo('Country');
	}

	public function language()
	{
		return $this->belongsTo('Language');
	}

	public function options()
	{
		return $this->belongsToMany('Option')->withPivot('value');
	}

	public function profile()
	{
		return $this->belongsTo('Profile');
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

		parent::boot(); // Validate the model

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
	 * @param  string $query
	 * @return Collection (of User)
	 */
	public static function search($query)
	{
		return self::where('name', 'LIKE', "%$query%")->orWhere('username', 'LIKE', "%$query%")->orderBy('username')->get();
	}

	/**
	 * Create a new user with a random username.
	 * If an $account is provided, the username will try to match the account username.
	 *
	 * @param  Account $account
	 * @return User
	 * @throws Exception
	 */
	public static function autoCreate(Account $account = null)
	{
		$profile = Profile::findOrFail(Config::get('site.auto-registration-profile'));

		// Generate a random username that is not already in use
		$usernameAvailable = false;
		$loopLimit = 100;
		while($loopLimit-- > 0 and ! $usernameAvailable)
		{
			$username = 'auto' . str_random(6); //to-do: try the username to match the data from $account
			$usernameAvailable = is_null(self::withTrashed()->where('username', $username)->first());
		}

		if($loopLimit <= 0)
			throw new Exception(_('Too many attempts'));

		// Attempt to create user
		$user = new User([
			'username' => $username,
			'name' => str_random(5), //to-do: try the name to match the data from $account
			'password' => $password = str_random(32),
			'password_confirmation' => $password,
			'profile_id' => $profile->id,
		]);

		if( ! $user->save())
			throw new Exception(_('Unable to create user'));

		return $user;
	}

	// UserInterface implementation for auth =======================================

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

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

		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	// RemindableInterface implementation for auth =================================

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 * @throws Exception
	 */
	public function getReminderEmail()
	{
		// Get the email from the most recently updated account
		foreach($this->accounts()->orderBy('updated_at', 'desc')->get() as $account)
		{
			if( ! is_null($account->email))
				return $account->email;
		}

		throw new Exception(_('No e-mail address found'));
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

			case 'profile_id':
				$table = 'profiles';
				$relatedColumn = 'name';
				break;

			case 'country_id':
				$table = 'countries';
				$relatedColumn = 'name';
				break;
		}

		$direction = (Input::get('sortdir') == 'desc') ? 'desc' : 'asc';

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
	 * @return Illuminate\Database\Eloquent\Collection
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
	 * @return Illuminate\Database\Eloquent\Collection
	*/
	public function getAssignableOptions()
	{
		return $this->getOptions(true);
	}

	/**
	 * Change $this user options.
	 *
	 * @param  array
	 * @return Illuminate\Support\MessageBag
	 */
	public function setOptions(array $options)
	{
		return Option::massAssignToUser($this, array_except($options, ['_method', '_token']));
	}
}
