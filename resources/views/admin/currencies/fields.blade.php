@foreach ($labels as $field => $label)

	{!! Form::label($field, $label) !!}
	@if ($field === 'symbol_position')

		{!! radios($field, [_('Left'), _('Right')]) !!}
		@if($errors->has($field))<small class="error">{{ $errors->first($field) }}</small>@endif

	@else
		{!! Form::text($field) !!}
	@endif

@endforeach
