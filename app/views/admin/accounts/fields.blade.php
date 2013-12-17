{{
	Form::label($f = 'provider_id', $labels->$f),
	Form::select($f, AuthProvider::dropdown('title')),

	Form::label($f = 'user_id', $labels->$f),
	Form::select($f, User::dropdown('username'))
}}

@foreach (array_except((array)$labels, ['provider_id', 'user_id']) as $field => $label)
	{{ Form::label($field, $label) }}
	{{ Form::text($field) }}
@endforeach
