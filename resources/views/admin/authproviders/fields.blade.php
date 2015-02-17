@foreach ($labels as $field => $label)
	{!! Form::label($field, $label) !!}
	{!! Form::text($field) !!}
@endforeach
