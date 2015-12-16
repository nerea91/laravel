@foreach (array_except((array) $labels, ['is_default']) as $field => $label)
	{!! Form::label($field, $label) !!}
	{!! Form::text($field) !!}
@endforeach

{!! Form::label($f = 'is_default', $labels->$f) !!}
{!! radios($f, [_('No'), _('Yes') ]) !!}
@if($errors->has($f))<small class="error">{{ $errors->first($f) }}</small>@endif
