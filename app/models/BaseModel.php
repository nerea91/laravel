<?php

/**
	This class adds to Eloquent:
	- Custom labels for database fields.
	- Validation in the model.
	- Validation uses custom labels instead of field names.
	- Compact 'unique' validation rule.
	- Global muttator to replace empty strings with NULL values.
	- Model event trigger.

	Usage example:

	class SomeModel extends BaseModel
	{
		public function __construct(array $attributes = array())
		{
			parent::__construct($attributes);
			$this->setRules(array(
				'name' => [_('Name'), 'required|max:64|unique'],
				'description' => [_('Description'), 'max:255'],
			));
		}
	}
*/

class BaseModel extends \Illuminate\Database\Eloquent\Model {

	/**
	 * Validation rules
	 *
	 * @var Array
	 */
	protected $rules = array();

	/**
	 * Field labels
	 *
	 * @var Array
	 */
	protected $labels = array();

	/**
	 * Error message bag
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $errors;

	// Meta ========================================================================

	// Validation ==================================================================

	/**
	 * Set validation rules and labels.
	 *
	 * @param  array
	 * @return Model
	 */
	protected function setRules(array $rules)
	{
		list($this->labels, $this->rules) = \Stolz\Validation\Validator::parseRules($rules);

		return $this;
	}

	/**
	 * Add a validation rule to a field.
	 *
	 * @param  string $field
	 * @param  string $rule
	 * @return Model
	 */
	public function setRule($field, $rule)
	{
		$key = explode(':', $rule);
		$this->rules[$field][$key[0]] = $rule;

		return $this;
	}

	/**
	 * Retrieve all rules for this model.
	 *
	 * @return array
	 */
	public function getRules()
	{
		return $this->rules;
	}

		/**
	 * Remove validation rules from a field.
	 *
	 * @param  string       $field
	 * @param  string|array $rules
	 * @return Model
	 */
	public function removeRule($field, $rules)
	{
		if( ! is_array($rules))
			$rules = explode('|', $rules);

		foreach($rules as $rule)
			unset($this->rules[$field][$rule]);

		return $this;
	}

	/**
	 * Validate current attributes against rules.
	 *
	 * @param  boolean $triggered_by_event
	 * @return boolean
	 */
	public function validate($triggered_by_event = false)
	{
		// Expand compact "unique" rules
		$table = $this->getTable();
		$except = ($this->getKey()) ? ','.$this->getKey() : null;
		$rules = $this->getRules();
		foreach($rules as $field => &$fieldRules)
		{
			foreach($fieldRules as &$rule)
			{
				if($rule == 'unique')
					$rule = "unique:$table,$field{$except}";
			}
		}

		// Validate
		$validator = \Validator::make($this->attributes, $rules);
		$validator->setAttributeNames($this->getLabels());

		if ( ! $validator->passes())
		{
			$this->setErrors($validator->messages());
			return false;
		}

		// Make sure save() wont get the *_confirmation attributes.
		// They make sense only for validation not for storage
		if($triggered_by_event)
		{
			foreach($this->attributes as $name => $value)
				if (ends_with($name, '_confirmation'))
					unset($this->{$name});
		}

		return true;
	}

	/**
	 * Determine if the model does not have any validation errors.
	 *
	 * @return boolean
	 */
	public function isValid()
	{
		return ! $this->hasErrors();
	}

	/**
	 * Determine if the model has any validation errors.
	 *
	 * @return boolean
	 */
	public function hasErrors()
	{
		return $this->errors->any();
	}

	/**
	 * Set error message bag.
	 *
	 * @param Illuminate\Support\MessageBag
	 * @return void
	 */
	protected function setErrors($errors)
	{
		$this->errors->merge($errors->toArray());
	}

	/**
	 * Retrieve error message bag.
	 *
	 * @return Illuminate\Support\MessageBag
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	// Relationships ===============================================================

	// Events ======================================================================

	/**
	 * Event listeners.
	 */
	protected static function boot()
	{
		parent::boot();

		//NOTE Create events sequence: saving -> creating -> created -> saved
		//NOTE Update events sequence: saving -> updating -> updated -> saved

		static::saving(function($model)
		{
			// Global muttator to convert empty attributes to null
			foreach ($model->toArray() as $name => $value)
			{
				if( ! is_null($value) and ! is_array($value))
				{
					$value = trim($value);
					if ( ! strlen($value))
						$model->{$name} = null;
				}
			}

			// Validate the model
			if( ! $model->validate(true))
				return false;
		});

		static::deleting(function($model)
		{
			// Check delete restrictions for the model
			if( ! $model->deletable(true))
				return false;
		});

	}

	/**
	 * Event trigger. For manually triggering model events.
	 */
	public function fireEvent($event)
	{
		$halt = ends_with($event, 'ing');

		return parent::fireModelEvent($event, $halt);
	}

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	/**
	 * Get an array suitable for an input[type=select]
	 *
	 * @param  strin $label Column used for labels
	 * @param  strin $value Column used for values
	 * @return array
	 */
	public static function dropdown($label = 'name', $value = 'id')
	{
		return self::orderBy($label)->lists($label, $value);
	}

	// Labels ======================================================================

	/**
	 * Add/replace $label for $field.
	 *
	 * @param string $field
	 * @param string $label
	 * @return Model
	 */
	public function addLabel($field, $label)
	{
		$this->labels[$field] = $label;

		return $this;
	}

	/**
	 * Retrieve the label for a $field.
	 *
	 * @param string $field
	 * @return string
	 */
	public function getLabel($field)
	{
		if( ! isset($this->labels[$field]))
			return null;

		return $this->labels[$field];
	}

	/**
	 * Retrieve all labels.
	 *
	 * @return array
	 */
	public function getLabels()
	{
		return $this->labels;
	}

	/**
	 * Retrieve labels of visible fields.
	 *
	 * @return array
	 */
	public function getVisibleLabels()
	{
		if (count($this->visible) > 0)
		{
			return array_intersect_key($this->labels, array_flip($this->visible));
		}

		return array_diff_key($this->labels, array_flip($this->hidden));
	}

	/**
	 * Retrieve labels of fillable fields.
	 *
	 * @return array
	 */
	public function getFillableLabels()
	{
		$fillable = array();

		foreach($this->labels as $key => $value)
		{
			if($this->isFillable($key))
				$fillable[$key] = $value;
		}

		return $fillable;
	}

	// Logic =======================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->errors = new \Illuminate\Support\MessageBag;
	}

	/**
	 * Determine whether or not the model can be deleted.
	 *
	 * @param  boolean $throwExceptions
	 * @throws ModelDeletionException
	 * @return boolean
	 */
	public function deletable($throwExceptions = false)
	{
		return true;
	}

	/**
	 * Sort model by parameters given in the URL
	 * i.e: ?sortby=name&sortdir=desc
	 *
	 * @return Illuminate\Database\Eloquent\Builder
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOrderByUrl($query)
	{
		$column = Input::get('sortby');
		if(in_array($column, array_keys($this->getVisibleLabels())))
		{
			$direction = (Input::get('sortdir') == 'desc') ? 'desc' : 'asc';
			return $query->orderBy($column, $direction);
		}

		return $query;
	}

	/**
	 * Convert to array using labels as keys.
	 *
	 * @return array
	 */
	public function toHumanArray()
	{
		$data = $this->toArray();
		foreach($data as $key => $value)
		{
			if($key == 'created_at')
			{
				unset($data[$key]);
				$data[_('Created at')] = $value;
			}
			elseif($key == 'updated_at')
			{
				unset($data[$key]);
				$data[_('Updated at')] = $value;
			}
			elseif($key == 'deleted_at')
			{
				unset($data[$key]);
				$data[_('Deleted at')] = $value;
			}
			elseif( ! is_null($label = $this->getLabel($key)))
			{
				unset($data[$key]);
				$data[$label] = $value;
			}
		}

		return $data;
	}

	/**
	 * Return las update date in localized format.
	 *
	 * @param  string $format
	 * @return string
	 */
	public function lastUpdate($format = '%A %d %B %Y @ %T (%Z)')
	{
		return $this->updated_at->formatLocalized($format);
	}

	/**
	 * Return las update date diff from now in human format.
	 *
	 * @return string
	 */
	public function lastUpdateDiff()
	{
		return $this->updated_at->diffForHumans();
	}

}
