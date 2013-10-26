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
	 * Error message bag
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $errors;

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

	/**
	 * Set validation rules and labels
	 *
	 * @param  array
	 * @return Model
	 */
	protected function setRules(array $rules)
	{
		$table = $this->getTable();
		$except = ($this->getKey()) ? ','.$this->getKey() : null;

		foreach($rules as $field => $labelAndRules)
		{
			list($label, $rules) = $labelAndRules;
			if( ! is_array($rules))
				$rules = explode('|', $rules);

			//Add label
			$this->labels[$field] = $label;

			//Expand compact "unique" rules
			foreach($rules as &$rule)
				if($rule == 'unique')
					$rule = "unique:$table,$field{$except}";

			//Add rule
			$this->rules[$field] = $rules;
		}

		return $this;
	}

	/**
	 * Validates current attributes against rules
	 *
	 * @return boolean
	 */
	public function validate()
	{
		//Create validator instance
		if( ! $this->validator)
			$this->validator = \App::make('validator');

		//Validate
		$v = $this->validator->make($this->attributes, $this->rules);

		if ($v->passes())
		{
			return true;
		}

		$this->setErrors($v->messages());
		return false;
	}

	/**
	 * Set error message bag
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected function setErrors($errors)
	{
		$this->errors = $errors;
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
	 * Inverse of wasSaved
	 *
	 * @return boolean
	 */
	public function hasErrors()
	{
		return ! empty($this->errors);
	}

}
