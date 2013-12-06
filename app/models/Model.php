<?php namespace Stolz\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
	This class adds to Eloquent:
	- Custom labels for database fields.
	- Validation in the model.
	- Validation uses custom labels instead of field names.
	- Compact 'unique' validation rule.
	- Global muttator to replace empty strings with NULL values.
	- Model event trigger.

	Usage example:

	class SomeModel extends \Stolz\Database\Model
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

class Model extends Eloquent {

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

	// Events ==================================================================

	/**
	 * Event listeners
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
				if( ! is_null($value))
				{
					$value = trim($value);
					if ( ! strlen($value))
						$model->{$name} = null;
				}
			}

			// Validate model before saving it
			if( ! $model->validate(true))
				return false;
		});
	}

	/**
	 * Event trigger
	 */
	public function fireEvent($event)
	{
		$halt = ends_with($event, 'ing');
		return parent::fireModelEvent($event, $halt);
	}

	// Logic ==================================================================

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->errors = new \Illuminate\Support\MessageBag;
	}

	/**
	 * Set validation rules and labels
	 *
	 * @param  array
	 * @return Model
	 */
	protected function setRules(array $rules)
	{
		foreach($rules as $field => $labelAndRules)
		{
			list($label, $rules) = $labelAndRules;

			// Add label
			$this->labels[$field] = $label;

			// Convert rules to associative array
			if( ! is_array($rules))
				$rules = explode('|', $rules);

			foreach($rules as $key => $value)
			{
				$new_key = explode(':', $value);
				$rules[$new_key[0]] = $value;
				unset($rules[$key]);
			}

			// Add rules
			$this->rules[$field] = $rules;
		}

		return $this;
	}

	/**
	 * Add a validation rule to a field
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
	 * Remove a validation rule from a field
	 *
	 * @param  string $field
	 * @param  string $rule
	 * @return Model
	 */
	public function removeRule($field, $rule)
	{
		unset($this->rules[$field][$rule]);
		return $this;
	}

	/**
	 * Retrieve all rules for this model
	 *
	 * @return array
	 */
	public function getRules()
	{
		return $this->rules;
	}

	/**
	 * Validate current attributes against rules
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
	 * Set error message bag
	 *
	 * @param Illuminate\Support\MessageBag
	 * @return void
	 */
	protected function setErrors($errors)
	{
		$this->errors->merge($errors->toArray());
	}

	/**
	 * Retrieve error message bag
	 *
	 * @return Illuminate\Support\MessageBag
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Determine whether or not the model has any validation errors
	 *
	 * @return boolean
	 */
	public function hasErrors()
	{
		return $this->errors->any();
	}

	/**
	 * Determine whether or not the model has any validation errors
	 *
	 * @return boolean
	 */
	public function isValid()
	{
		return ! $this->hasErrors();
	}

	/**
	 * Retrieve one labels
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
	 * Retrieve all labels
	 *
	 * @return array
	 */
	public function getLabels()
	{
		return $this->labels;
	}

	/**
	 * Retrieve labels of visible fields
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
	 * Retrieve labels of fillable fields
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

}
