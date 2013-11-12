<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| such as the size rules. Feel free to tweak each of these messages.
	|
	*/

	"accepted"         => _("The :attribute must be accepted."),
	"active_url"       => _("The :attribute is not a valid URL."),
	"after"            => _("The :attribute must be a date after :date."),
	"alpha"            => _("The :attribute may only contain letters."),
	"alpha_dash"       => _("The :attribute may only contain letters, numbers, and dashes."),
	"alpha_num"        => _("The :attribute may only contain letters and numbers."),
	"array"            => _("The :attribute must be an array."),
	"before"           => _("The :attribute must be a date before :date."),
	"between"          => array(
		"numeric" => _("The :attribute must be between :min - :max."),
		"file"    => _("The :attribute must be between :min - :max kilobytes."),
		"string"  => _("The :attribute must be between :min - :max characters."),
		"array"   => _("The :attribute must have between :min - :max items."),
	),
	"confirmed"        => _("The :attribute confirmation does not match."),
	"date"             => _("The :attribute is not a valid date."),
	"date_format"      => _("The :attribute does not match the format :format."),
	"different"        => _("The :attribute and :other must be different."),
	"digits"           => _("The :attribute must be :digits digits."),
	"digits_between"   => _("The :attribute must be between :min and :max digits."),
	"email"            => _("The :attribute format is invalid."),
	"exists"           => _("The selected :attribute is invalid."),
	"image"            => _("The :attribute must be an image."),
	"in"               => _("The selected :attribute is invalid."),
	"integer"          => _("The :attribute must be an integer."),
	"ip"               => _("The :attribute must be a valid IP address."),
	"max"              => array(
		"numeric" => _("The :attribute may not be greater than :max."),
		"file"    => _("The :attribute may not be greater than :max kilobytes."),
		"string"  => _("The :attribute may not be greater than :max characters."),
		"array"   => _("The :attribute may not have more than :max items."),
	),
	"mimes"            => _("The :attribute must be a file of type: :values."),
	"min"              => array(
		"numeric" => _("The :attribute must be at least :min."),
		"file"    => _("The :attribute must be at least :min kilobytes."),
		"string"  => _("The :attribute must be at least :min characters."),
		"array"   => _("The :attribute must have at least :min items."),
	),
	"not_in"           => _("The selected :attribute is invalid."),
	"numeric"          => _("The :attribute must be a number."),
	"regex"            => _("The :attribute format is invalid."),
	"required"         => _("The :attribute field is required."),
	"required_if"      => _("The :attribute field is required when :other is :value."),
	"required_with"    => _("The :attribute field is required when :values is present."),
	"required_without" => _("The :attribute field is required when :values is not present."),
	"same"             => _("The :attribute and :other must match."),
	"size"             => array(
		"numeric" => _("The :attribute must be :size."),
		"file"    => _("The :attribute must be :size kilobytes."),
		"string"  => _("The :attribute must be :size characters."),
		"array"   => _("The :attribute must contain :size items."),
	),
	"unique"           => _("The :attribute has already been taken."),
	"url"              => _("The :attribute format is invalid."),

	"alpha_space"      => _("The :attribute may only contain letters and spaces."),
	"alpha_dash_space" => _("The :attribute may only contain letters, numbers, dashes and spaces."),
	"alpha_num_space"  => _("The :attribute may only contain letters, numbers and spaces."),


	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
