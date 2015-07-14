<?php namespace App\Validation;

use Illuminate\Validation\Validator as UpstreamValidator;

class Validator extends UpstreamValidator
{
	/**
	 * Create a new Validator instance.
	 *
	 * @param  \Symfony\Component\Translation\TranslatorInterface $translator
	 * @param  array                                              $data
	 * @param  array                                              $rules
	 * @param  array                                              $messages
	 *
	 * @return void
	 */
	public function __construct($translator, $data, $rules, $messages = [])
	{
		parent::__construct($translator, $data, $rules, $messages);

		$this->numericRules[] = 'Positive';
	}

	/**
	 * Validate that an attribute contains only alphabetic characters and spaces.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 *
	 * @return bool
	 */
	protected function validateAlphaSpace($attribute, $value)
	{
		return preg_match('/^[\pL\s]+$/u', $value);
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters and spaces.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 *
	 * @return bool
	 */
	protected function validateAlphaNumSpace($attribute, $value)
	{
		return preg_match('/^[\pL\pN\s]+$/u', $value);
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters, spaces, dashes, and underscores.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 *
	 * @return bool
	 */
	protected function validateAlphaDashSpace($attribute, $value)
	{
		return preg_match('/^[\pL\pN_\-\s]+$/u', $value);
	}

	/**
	 * Validate that an attribute is numeric and greather than 0.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 *
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
	 * @param  string $attribute
	 * @param  mixed  $value
	 * @param  array  $parameters
	 *
	 * @return bool
	 */
	protected static function validateMaxLength($attribute, $value, $parameters)
	{
		return (strlen($value) <= $parameters[0]);
	}

	/**
	 * Validate that an attribute has at least the given length.
	 * Intended for numeric values. For string valures use the native size() function.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 * @param  array  $parameters
	 *
	 * @return bool
	 */
	protected static function validateMinLength($attribute, $value, $parameters)
	{
		return (strlen($value) >= $parameters[0]);
	}

	/**
	 * Validate that an attribute has the given length.
	 * Intended for numeric values. For string valures use the native size() function.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 * @param  array  $parameters
	 *
	 * @return bool
	 */
	protected static function validateLength($attribute, $value, $parameters)
	{
		return (strlen($value) == $parameters[0]);
	}

	/**
	 * Validate the uniqueness of an the combination of several attributes values on a given database table.
	 *
	 * @author Felix Kiss https://github.com/felixkiss/uniquewith-validator/. MIT License.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 * @param  array  $parameters
	 *
	 * @return bool
	 */
	public function validateUniqueWith($attribute, $value, $parameters)
	{
		$table = $parameters[0];

		// The second parameter position holds the name of the column that needs to
		// be verified as unique. If this parameter isn't specified we will just
		// assume that this column to be verified shares the attribute's name.
		// $column = isset($parameters[1]) ? $parameters[1] : $attribute;
		$column = $attribute;

		// Create $extra array with all other columns, so getCount() will include
		// them as where clauses as well
		$extra = [];

		// Check if last parameter is an integer. If it is, then it will ignore the row with the specified id - useful when updating a row
		$parameters_length = sizeof($parameters);
		$ignore_id = null;

		if($parameters_length > 1)
		{
			$last_param = $parameters[$parameters_length - 1];
			$last_param_value = str_replace(" ", "", $parameters[$parameters_length - 1]);
			if(preg_match('/^[1-9][0-9]*$/', $last_param_value))
			{
				$last_param_value = intval($last_param_value);
				if($last_param_value > 0)
				{
					$ignore_id = $last_param_value;
					$parameters_length--;
				}
			}
		}

		for($i = 1; $i < $parameters_length; $i++)
		{
			// Figure out whether field_name is the same as column_name
			// or column_name is explicitly specified.
			//
			// case 1:
			//     $parameter = 'last_name'
			//     => field_name = column_name = 'last_name'
			// case 2:
			//     $parameter = 'last_name=sur_name'
			//     => field_name = 'last_name', column_name = 'sur_name'
			$parameter = explode('=', $parameters[$i], 2);
			$field_name = trim($parameter[0]);

			if(count($parameter) > 1)
				$column_name = trim($parameter[1]);
			else
				$column_name = $field_name;

			// Figure out whether main field_name has an explicitly specified column_name
			if($field_name == $column)
				$column = $column_name;
			else
				$extra[$column_name] = array_get($this->data, $field_name);
		}

		// The presence verifier is responsible for counting rows within this store
		// mechanism which might be a relational database or any other permanent
		// data store like Redis, etc. We will use it to determine uniqueness.
		$verifier = $this->getPresenceVerifier();

		return $verifier->getCount($table, $column, $value, $ignore_id, null, $extra) == 0;
	}

	/**
	 * Validate a 24h time with optional leading zeros and optional seconds.
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 *
	 * @return bool
	 */
	protected function validateTime($attribute, $value)
	{
		return preg_match('/(2[0-3]|[0-1]?[0-9]):[0-5]?[0-9](:[0-5]?[0-9])?/', $value);
	}

	/**
	 * Validate a n-tuple of hexadecimal characters.
	 *
	 * i.e: To validate A1B2-C3D4-E5F6-A1B2-C3D4-E5F6 use rule hex_tuple:4,6
	 *
	 * @param  string $attribute
	 * @param  mixed  $value
	 * @param  array  $parameters First paramer is number of characters per element, second is number of elements. (aka the 'n' from the n-tuple).
	 *
	 * @return bool
	 */
	public function validateHexTuple($attribute, $value, $parameters)
	{
		list($charactersPerGroup, $numberOfGroups) = $parameters;

		$regex = implode('-', array_fill(0, $numberOfGroups, "[a-f0-9]{{$charactersPerGroup}}"));

		return preg_match("/^$regex$/i", $value);
	}

	/**
	 * Replace all place-holders for the above rules.
	 *
	 * @param  string $message
	 * @param  string $attribute
	 * @param  string $rule
	 * @param  array  $parameters
	 *
	 * @return string
	 */
	protected function replaceMaxLength($message, $attribute, $rule, $parameters)
	{
		return $this->replaceLength($message, $attribute, $rule, $parameters);
	}

	protected function replaceMinLength($message, $attribute, $rule, $parameters)
	{
		return $this->replaceLength($message, $attribute, $rule, $parameters);
	}

	protected function replaceLength($message, $attribute, $rule, $parameters)
	{
		return str_replace([':length'], $parameters, $message);
	}

	protected function replaceUniqueWith($message, $attribute, $rule, $parameters)
	{
		$fields = [$attribute];
		$size = sizeof($parameters);

		for($i = 1; $i < $size; $i++)
			$fields[] = $parameters[$i];
		$fields = implode(', ', $fields);

		return str_replace(':fields', $fields, $message);
	}

	protected function replaceHexTuple($message, $attribute, $rule, $parameters)
	{
		list($charactersPerGroup, $numberOfGroups) = $parameters;

		$sample = implode('-', array_fill(0, $numberOfGroups, str_repeat('F', $charactersPerGroup)));
		$message = str_replace(':n', $numberOfGroups, $message);
		$message = str_replace(':characters', $charactersPerGroup, $message);
		$message = str_replace(':sample', $sample, $message);

		return $message;
	}

	/**
	 * Parse validation rules in compact format.
	 *
	 * Converts:
	 *
	 * [
	 *   'field1' => ['Label1', 'rule1|rule11'],
	 *   'field2' => ['Label2', ['rule2','rule22']],
	 * ];
	 *
	 * To:
	 *
	 * [
	 *   'labels' => [
	 *     'field1' => 'Label1',
	 *     'field2' => 'Label2',
	 *   ],
	 *   'rules' => [
	 *     'field1' => ['rule1', 'rule11'],
	 *   'field2' => ['rule2', 'rule22'],
	 *  ]
	 *];
	 *
	 * @param  array
	 *
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
