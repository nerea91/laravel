<?php namespace App;

use Illuminate\Database\Eloquent\Model as UpstreamModel;
use Input;
use Validator;

abstract class Model extends UpstreamModel
{
	/**
	 * Validation rules
	 *
	 * @var Array
	 */
	protected $rules = [];

	/**
	 * Field labels
	 *
	 * @var Array
	 */
	protected $labels = [];

	/**
	 * Error message bag
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $errors;

	// Meta ========================================================================

	/**
	 * Singular form of this model's name.
	 *
	 * @return string
	 */
	public function singular()
	{
		return str_singular(get_called_class());
	}

	/**
	 * Plural form of this model's name.
	 *
	 * @return string
	 */
	public function plural()
	{
		return str_plural(get_called_class());
	}

	/**
	 * What should be returned when this model is casted to string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->getKey();
	}

	// Validation ==================================================================

	/**
	 * Set validation rules and labels.
	 *
	 * @param  array
	 *
	 * @return Model
	 */
	protected function setRules(array $rules)
	{
		list($this->labels, $this->rules) = \App\Validation\Validator::parseRules($rules);

		return $this;
	}

	/**
	 * Add a validation rule to a field.
	 *
	 * @param  string $field
	 * @param  string $rule
	 *
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
	 *
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
	 * @param  boolean $triggeredByEvent
	 *
	 * @return boolean
	 */
	public function validate($triggeredByEvent = false)
	{
		// If $this has 'id' use it as excluded key for "unique" and "unique_with" rules
		$table = $this->getTable();
		$except = ($this->getKey()) ? ',' . $this->getKey() : null;
		$rules = $this->getRules();
		foreach($rules as $field => &$fieldRules)
		{
			foreach($fieldRules as $ruleName => &$ruleData)
			{
				if($ruleData === 'unique')
					$ruleData = "unique:$table,$field{$except}";

				if($ruleName === 'unique_with')
					$ruleData = "{$ruleData}{$except}";
			}
		}

		// Validate
		$validator = Validator::make($this->attributes, $rules);
		$validator->setAttributeNames($this->getLabels());

		if( ! $validator->passes())
		{
			$this->setErrors($validator->messages());

			return false;
		}

		// Make sure save() wont get the *_confirmation attributes.
		// They make sense only for validation not for storage
		if($triggeredByEvent)
		{
			foreach($this->attributes as $name => $value)
				if(ends_with($name, '_confirmation'))
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
	 * @param \Illuminate\Support\MessageBag
	 *
	 * @return void
	 */
	protected function setErrors($errors)
	{
		$this->errors->merge($errors->toArray());
	}

	/**
	 * Retrieve error message bag.
	 *
	 * @return \Illuminate\Support\MessageBag
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
		// NOTE saving   -> creating -> created   -> saved
		// NOTE saving   -> updating -> updated   -> saved
		// NOTE deleting -> deleted  -> restoring -> restored

		parent::boot();

		static::saving(function ($model) {
			// Global muttator to convert empty attributes to null
			$model->convertEmptyAttributesToNull();
		});

		static::creating(function ($model) {
			// Validate the model
			if( ! $model->validate(true))
				return false;
		});

		static::updating(function ($model) {
			// Validate the model
			if( ! $model->validate(true))
				return false;
		});

		static::deleting(function ($model) {
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
	 *
	 * @return array
	 */
	public static function dropdown($label = 'name', $value = 'id')
	{
		return self::orderBy($label)->pluck($label, $value)->all();
	}

	// Labels ======================================================================

	/**
	 * Add/replace $label for $field.
	 *
	 * @param string $field
	 * @param string $label
	 *
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
	 *
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
		if(count($this->visible) > 0)
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
		$fillable = [];

		foreach($this->labels as $key => $value)
		{
			if($this->isFillable($key))
				$fillable[$key] = $value;
		}

		return $fillable;
	}

	// Logic =======================================================================

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->errors = new \Illuminate\Support\MessageBag;
	}

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
		return true;
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
		if(in_array($column, array_keys($this->getVisibleLabels())))
		{
			$direction = (Input::get('sortdir') === 'desc') ? 'desc' : 'asc';

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
			if($key === 'created_at')
			{
				unset($data[$key]);
				$data[_('Created at')] = $value;
			}
			elseif($key === 'updated_at')
			{
				unset($data[$key]);
				$data[_('Updated at')] = $value;
			}
			elseif($key === 'deleted_at')
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
	 *
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

	/**
	 * Restore provided model attributes to their original state.
	 *
	 * @param  mixed
	 *
	 * @return Model
	 */
	public function restoreOriginalAttributes($attributes)
	{
		$attributes = is_array($attributes) ? $attributes : func_get_args();
		foreach($attributes as $attribute)
			$this->$attribute = $this->getOriginal($attribute);

		return $this;
	}

	/**
	 * Convert empty attributes to null
	 *
	 * @return Model
	 */
	public function convertEmptyAttributesToNull()
	{
		foreach($this->toArray() as $attribute => $value)
		{
			if( ! is_null($value) and ! is_array($value))
			{
				$value = trim($value);
				if( ! strlen($value))
					$this->{$attribute} = null;
			}
		}

		return $this;
	}
}
