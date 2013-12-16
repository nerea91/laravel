@foreach ($labels as $field => $label)

	{{ Form::label($field, $label) }}
	@if ($field == 'symbol_position')

		@if($errors->has($field))<small class="error">{{ $errors->first($field) }}</small>@endif
		{{ Form::radios($field, [_('Left'), _('Right')]) }}

	@else
		{{ Form::text($field) }}
	@endif

@endforeach
