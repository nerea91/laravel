{{
	Form::label($f = 'name', $resource->getLabel($f)),
	Form::text($f),

	Form::label($f = 'description', $resource->getLabel($f)),
	Form::text($f)
}}

@if($e = $errors->has('permissions'))<div class="error">@endif

{{ Form::label('permissions', _('Permissions'))}}
@if($e)<small>{{ $errors->first('permissions') }}</small>@endif

@foreach ($types as $type_id => $type)
	{{ Form::checkboxes('permissions', $permissions[$type_id], [], ['legend' => $type]) }}
@endforeach

@if($e)</div>@endif


