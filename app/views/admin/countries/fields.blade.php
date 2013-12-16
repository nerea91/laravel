@foreach (array_except((array)$labels, ['eea', 'currency_id']) as $field => $label)
	{{ Form::label($field, $label) }}
	{{ Form::text($field) }}
@endforeach

{{ Form::label($f = 'eea', $labels->$f) }}
@if($errors->has($f))<small class="error">{{ $errors->first($f) }}</small>@endif
{{ Form::radios($f, [_('No'), _('Yes') ]) }}

{{
	Form::label($f = 'currency_id', $resource->getLabel($f)),
	Form::select($f, ['' => _('Unknown')] + Currency::dropdown())
}}
