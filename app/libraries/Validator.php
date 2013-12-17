<?php namespace Stolz\Validation;

class Validator extends \Illuminate\Validation\Validator {

	/**
	 * Create a new Validator instance.
	 *
	 * @param  \Symfony\Component\Translation\TranslatorInterface  $translator
	 * @param  array  $data
	 * @param  array  $rules
	 * @param  array  $messages
	 * @return void
	 */
	public function __construct($translator, $data, $rules, $messages = array())
	{
		parent::__construct($translator, $data, $rules, $messages);

		$this->numericRules[] = 'Positive';
	}

	/**
	 * Validate that an attribute contains only alphabetic characters and spaces.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateAlphaSpace($attribute, $value)
	{
		return preg_match('/^[\pL\s]+$/u', $value);
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters and spaces.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateAlphaNumSpace($attribute, $value)
	{
		return preg_match('/^[\pL\pN\s]+$/u', $value);
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters, spaces, dashes, and underscores.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateAlphaDashSpace($attribute, $value)
	{
		return preg_match('/^[\pL\pN_-\s]+$/u', $value);
	}

	/**
	 * Validate that an attribute is numeric and greather than 0.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validatePositive($attribute, $value)
	{
		return is_numeric($value) and $value > 0;
	}

	/**
	 * Validate that an attribute has no more than the given length.
	 * Intended for numeric values. For string valures use the native size() function.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @param  array   $parameters
	 * @return bool
	 */
	protected static function validateMaxLength($attribute, $value, $parameters) {
		return (strlen($value) <= $parameters[0]);
	}

	/**
	 * Validate that an attribute has at least the given length.
	 * Intended for numeric values. For string valures use the native size() function.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @param  array   $parameters
	 * @return bool
	 */
	protected static function validateMinLength($attribute, $value, $parameters) {
		return (strlen($value) >= $parameters[0]);
	}

	/**
	 * Validate that an attribute has the given length.
	 * Intended for numeric values. For string valures use the native size() function.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @param  array   $parameters
	 * @return bool
	 */
	protected static function validateLength($attribute, $value, $parameters) {
		return (strlen($value) == $parameters[0]);
	}

	/**
	 * Replace all place-holders for the between rule.
	 *
	 * @param  string  $message
	 * @param  string  $attribute
	 * @param  string  $rule
	 * @param  array   $parameters
	 * @return string
	 */
	protected function replaceMaxLength($message, $attribute, $rule, $parameters) { return $this->replaceLength($message, $attribute, $rule, $parameters);}
	protected function replaceMinLength($message, $attribute, $rule, $parameters) { return $this->replaceLength($message, $attribute, $rule, $parameters);}
	protected function replaceLength($message, $attribute, $rule, $parameters)
	{
		return str_replace(array(':length'), $parameters, $message);
	}

	/**
	 * Parse validation rules in compact format.
	 *
	 * Converts:
	 *
	 		[
	 			'field1' => ['Label1', 'rule1|rule11'],
	 			'field2' => ['Label2', ['rule2','rule22']],
	 		];

	 * To:

	 		[
	 			'labels' => [
	 				'field1' => 'Label1',
					'field2' => 'Label2',
				],
				'rules' => [
					'field1' => ['rule1', 'rule11'],
					'field2' => ['rule2', 'rule22'],
				]
			];
	 *
	 * @param  array
	 * @return array
	 */
	public static function parseRules(array $originalRules)
	{
		$parsed = ['labels' => [], 'rules' => []];

		foreach($originalRules as $field => $labelAndRules)
		{
			list($label, $rules) = $labelAndRules;

			// Add label
			$parsed['labels'][$field] = $label;

			// Sometimes a column has no rules
			if(is_null($rules))
				continue;

			// Convert rules to array
			if( ! is_array($rules))
				$rules = explode('|', $rules);

			// Convert rules to associative array
			foreach($rules as $key => $value)
			{
				$new_key = explode(':', $value);
				$rules[$new_key[0]] = $value;
				unset($rules[$key]);
			}

			// Add rules
			$parsed['rules'][$field] = $rules;
		}

		return array_values($parsed);
	}
}
