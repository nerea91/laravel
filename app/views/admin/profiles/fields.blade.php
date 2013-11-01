{{
	Form::label($f = 'name', $resource->getLabel($f)),
	Form::text($f),

	Form::label($f = 'description', $resource->getLabel($f)),
	Form::text($f)
}}

<div class="{{ ($errors->has('permissions')) ? 'error' : null }}">
	{{ Form::label('permissions', _('Permissions'))}}

	@foreach ($types as $type_id => $type)
		{{ Form::checkboxes('permissions', $permissions[$type_id], [], ['legend' => $type]) }}
	@endforeach
</div>


