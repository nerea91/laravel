@foreach (array_except((array)$labels, ['is_default']) as $field => $label)
	{{ Form::label($field, $label) }}
	{{ Form::text($field) }}
@endforeach

{{ Form::label($f = 'is_default', $labels->$f) }}
@if($errors->has($f))<small class="error">{{ $errors->first($f) }}</small>@endif
{{ Form::radios($f, [_('No'), _('Yes') ]) }}
