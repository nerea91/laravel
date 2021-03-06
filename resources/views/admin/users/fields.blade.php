{!!
	Form::label($f = 'username', $resource->getLabel($f)),
	Form::text($f, null, ['autocomplete' => 'off']),

	Form::label($f = 'profile_id', $resource->getLabel($f)),
	Form::select($f, $profiles),

	Form::label($f = 'password', $resource->getLabel($f)),
	Form::password($f, null, ['autocomplete' => 'off']),

	Form::label($f = 'password_confirmation', _('Repeat password')),
	Form::password($f, null, ['autocomplete' => 'off'])

!!}

<fieldset>
	<legend>{{ _('Optional') }}</legend>
	{!!
		Form::label($f = 'name', $resource->getLabel($f)),
		Form::text($f, null, ['autocomplete' => 'off']),

		Form::label($f = 'description', $resource->getLabel($f)),
		Form::text($f, null, ['autocomplete' => 'off']),

		Form::label($f = 'country_id', $resource->getLabel($f)),
		Form::select($f, ['' => _('Unknown')] + App\Country::dropdown()),

		Form::label($f = 'language_id', $resource->getLabel($f)),
		Form::select($f, ['' => _('Default')] + App\Language::dropdown())
	!!}
</fieldset>
