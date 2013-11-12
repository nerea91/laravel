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
	public function __construct(TranslatorInterface $translator, $data, $rules, $messages = array())
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
}
