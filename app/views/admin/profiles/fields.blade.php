@foreach ($labels as $field => $label)
	{{ Form::label($field, $label) }}
	{{ Form::text($field) }}
@endforeach

{{ Form::label('permissions', _('Permissions'), ['class' => ($errors->has('permissions')) ? 'error' : null]) }}
