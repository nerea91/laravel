<?php namespace Stolz\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
	This class adds to Eloquent:
	- Validation in the model.
	- Labels for database fields.
	- Compact 'unique' validation rule.

	Usage example:

	class SomeModel extends Stolz\Database\Model
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
	 * Validator instance
	 *
	 * @var Illuminate\Validation\Validators
	 */
	protected $validator;

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
	 * Listen for save event
	 */
	protected static function boot()
	{
		parent::boot();

		static::saving(function($model)
		{
			return $model->validate();
		});
	}

	// Logic ==================================================================

		public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->errors = new \Illuminate\Support\MessageBag;
	}

	/**
	 * Validate current attributes against rules
	 *
	 * @return boolean
	 */
	public function validate()
	{
		//Expand compact "unique" rules
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

		//Create validator instance
		if( ! $this->validator)
			$this->validator = \App::make('validator');

		//Validate
		$validation = $this->validator->make($this->attributes, $rules);

		if ($validation->passes())
		{
			return true;
		}

		$this->setErrors($validation->messages());
		return false;
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

			//Add label
			$this->labels[$field] = $label;

			//Add rules
			$this->rules[$field] = (is_array($rules)) ? $rules : explode('|', $rules);
		}

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
	 * Deterine if there are any validation errors
	 *
	 * @return boolean
	 */
	public function hasErrors()
	{
		return $this->errors->any();
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

}
