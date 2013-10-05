@extends('layouts.scaffold')

@section('main')

<h1>Edit Phone</h1>
{{ Form::model($phone, array('method' => 'PATCH', 'route' => array('phones.update', $phone->id))) }}
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
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('phones.show', 'Cancel', $phone->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
