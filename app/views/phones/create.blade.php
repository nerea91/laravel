@extends('layouts.scaffold')

@section('main')

<h1>Create Phone</h1>

{{ Form::open(array('route' => 'phones.store')) }}
	<ul>
        <li>
            {{ Form::label('number', 'Number:') }}
            {{ Form::input('number', 'number') }}
        </li>

        <li>
            {{ Form::label('imei', 'Imei:') }}
            {{ Form::text('imei') }}
        </li>

		<li>
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


