<?php namespace Stolz\Validation;

class Validator extends \Illuminate\Validation\Validator{

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
}
