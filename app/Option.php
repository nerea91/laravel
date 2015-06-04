<?php namespace App;

use Illuminate\Support\MessageBag;
use Validator;

class Option extends Model
{
	public $timestamps = false;
	protected $guarded = array('id', 'assignable', 'deleted_at');

	// Meta ========================================================================

	/**
	 * Singular form of this model's name
	 *
	 * @return string
	 */
	public function singular()
	{
		return _('Option');
	}

	/**
	 * Plural form of this model's name
	 *
	 * @return string
	 */
	public function plural()
	{
		return _('Options');
	}

	/**
	 * What should be returned when this model is casted to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->label . ': '. $this->value;
	}

	// Validation ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Internal name'), 'required|min:3|max:32|alpha_dash|unique'],
			'label' => [_('Label'), 'required|max:64|unique'],
			'description' => [_('Description'), 'max:128'],
			'value' => [_('Value'), 'required|max:64'],
			'assignable' => [_('Assignable'), 'required|max:1|min:0'],
			'rules' => [_('Validation rules'), 'required|max:255'],
		));
	}

	// Relationships ===============================================================

	public function users()
	{
		return $this->belongsToMany('App\User')->withPivot('value');
	}

	// Events ======================================================================

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Assig more than one option to an $user
	 *
	 * @param  User
	 * @param  array
	 * @return \Illuminate\Support\MessageBag
	 */
	public static function massAssignToUser(User $user, array $options)
	{
		$errors = new MessageBag;
		foreach($options as $name => $value)
			$errors->merge(self::whereName($name)->firstOrFail()->assignToUser($user, $value)->toArray());

		return $errors;
	}

	// Logic =======================================================================

	/**
	 * Check wether or not $this option is assigned to $user
	 *
	 * @param  User
	 * @return boolean
	 */
	public function assignedToUser(User $user)
	{
		 return (bool) $user->options()->where('options.id', $this->getKey())->first();
	}

	/**
	 * Validate $this option and assign it to $user.
	 *
	 * @param  User
	 * @param  string
	 * @return \Illuminate\Support\MessageBag
	 */
	public function assignToUser(User $user, $value)
	{
		$errors = new MessageBag;

		// If it's non assignable user can't choose value. Use default.
		if ( ! $this->assignable)
		{
			// Make sure we don't overwrite and already existing non assignable user option
			if( ! $this->assignedToUser($user) and ! $this->syncWithUser($user))
				$errors->add($this->name, _('Unable to save option to data base'));

			return $errors;
		}

		// Validate and save
		$validator = Validator::make([$this->name => $value], [$this->name => $this->validation_rules]);
		$validator->setAttributeNames([$this->name => $this->label]);

		if($validator->passes() and ! $this->syncWithUser($user, $value))
			$errors->add($this->name, _('Unable to save option to data base'));

		return $errors->merge($validator->messages());
	}

	/**
	 * Assign $this option to an $user without validating the value.
	 * If option is not assigned to user add the relation, otherwise udpate it.
	 *
	 * @param  User
	 * @param  string
	 * @return boolean
	 */
	public function syncWithUser(User $user, $value = null)
	{
		// If no value is provided use default
		$value = (is_null($value)) ? $this->value : $value;

		/* NOTE:
		 * Both updateExistingPivot/attach methods return the number of affeted rows.
		 * When the value didn't change this may be seen as a query failure but it's not.
		 * Therefore the return value is always hardcoded as "true".
		 */

		// If already exist update it
		if ($this->assignedToUser($user))
			return $user->options()->updateExistingPivot($this->getKey(), ['value' => $value], false) or true;

		// Otherwise add it
		return $user->options()->attach($this->getKey(), ['value' => $value]) or true;
	}
}
