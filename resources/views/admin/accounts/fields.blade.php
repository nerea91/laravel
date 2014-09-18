{{-- Show provider and user dropdown only id we are creating the account --}}
@if ( ! $resource->id)
{!!
	Form::label($f = 'provider_id', $labels->$f),
	Form::select($f, App\AuthProvider::dropdown('title')),

	Form::label($f = 'user_id', $labels->$f),
	Form::select($f, App\User::dropdown('username'))
!!}
@endif

@foreach (array_except((array) $labels, ['provider_id', 'user_id']) as $field => $label)
	{!! Form::label($field, $label) !!}
	{!! Form::text($field) !!}
@endforeach
