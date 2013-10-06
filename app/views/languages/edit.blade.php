@extends('layouts.scaffold')

@section('main')

<h1>Edit Language</h1>
{{ Form::model($language, array('method' => 'PATCH', 'route' => array('languages.update', $language->id))) }}
	<ul>
        <li>
            {{ Form::label('code', 'Code:') }}
            {{ Form::text('code') }}
        </li>

        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('english_name', 'English_name:') }}
            {{ Form::text('english_name') }}
        </li>

        <li>
            {{ Form::label('locale', 'Locale:') }}
            {{ Form::text('locale') }}
        </li>

        <li>
            {{ Form::label('default', 'Default:') }}
            {{ Form::checkbox('default') }}
        </li>

        <li>
            {{ Form::label('priority', 'Priority:') }}
            {{ Form::input('number', 'priority') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('languages.show', 'Cancel', $language->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
