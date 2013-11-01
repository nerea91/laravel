{{
	Form::label($f = 'name', $resource->getLabel($f)),
	Form::text($f),

	Form::label($f = 'description', $resource->getLabel($f)),
	Form::text($f)
}}

<div class="{{ ($e = $errors->has('permissions')) ? 'error' : null }}">
	{{ Form::label('permissions', _('Permissions'))}}
	@if($e)<small>{{ $errors->first('permissions') }}</small>@endif

	@foreach ($types as $type_id => $type)
	{{ Form::checkboxes('permissions', $all[$type_id], $checked, ['legend' => $type]) }}
	@endforeach
</div>


