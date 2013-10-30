{{
	Form::label($f = 'name', $resource->getLabel($f)),
	Form::text($f),

	Form::label($f = 'desciption', $resource->getLabel($f)),
	Form::text($f)
}}

{{ Form::label('profile.permissions', _('Permissions'), ['class' => ($errors->has('profile.permissions')) ? 'error' : null]) }}
@foreach ($types as $type_id => $type)
	{{ Form::checkboxes('profile.permissions', $permissions[$type_id], [], ['legend' => $type]) }}
@endforeach

