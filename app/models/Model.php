<?php namespace Stolz;

/* Usage example:

	public function __construct(array $attributes = array())
	{
		parent::__construct($attributes);
		$this->setRules(array(
			'name' => [_('Name'), 'required|max:64|unique'],
			'description' => [_('Description'), 'max:255'],
		));
	}
*/

class Model extends \Illuminate\Database\Eloquent\Model {

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
	protected static $rules = array();

	/**
	 * Fields labels
	 *
	 * @var Array
	 */
	protected static $labels = array();

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
	 * @return void
	 */
	protected function setRules(array $rules)
	{
		$table = $this->getTable();
		$except = ($this->getKey()) ? ','.$this->getKey() : null;

		foreach($rules as $field => $labelAndrules)
		{
			list($label, $rules) = $labelAndrules;
			if( ! is_array($rules))
				$rules = explode('|', $rules);

			//Set label
			self::$labels[$field] = $label;

			//Expand compact "unique" rules
			foreach($rules as &$rule)
				if($rule == 'unique')
					$rule = "unique:$table,$field{$except}";

			//Set rules
			self::$rules[$field] = $rules;
		}
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
		$v = $this->validator->make($this->attributes, static::$rules);

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
	 * Inverse of wasSaved
	 *
	 * @return boolean
	 */
	public function hasErrors()
	{
		return ! empty($this->errors);
	}

}
