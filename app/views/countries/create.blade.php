@extends('layouts.scaffold')

@section('main')

<h1>Create Country</h1>

{{ Form::open(array('route' => 'countries.store')) }}
	<ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('full_name', 'Full_name:') }}
            {{ Form::text('full_name') }}
        </li>

        <li>
            {{ Form::label('iso_3166_2', 'Iso_3166_2:') }}
            {{ Form::text('iso_3166_2') }}
        </li>

        <li>
            {{ Form::label('iso_3166_3', 'Iso_3166_3:') }}
            {{ Form::text('iso_3166_3') }}
        </li>

        <li>
            {{ Form::label('country_code', 'Country_code:') }}
            {{ Form::text('country_code') }}
        </li>

        <li>
            {{ Form::label('capital', 'Capital:') }}
            {{ Form::text('capital') }}
        </li>

        <li>
            {{ Form::label('citizenship', 'Citizenship:') }}
            {{ Form::text('citizenship') }}
        </li>

        <li>
            {{ Form::label('currency', 'Currency:') }}
            {{ Form::text('currency') }}
        </li>

        <li>
            {{ Form::label('currency_code', 'Currency_code:') }}
            {{ Form::text('currency_code') }}
        </li>

        <li>
            {{ Form::label('currency_sub_unit', 'Currency_sub_unit:') }}
            {{ Form::text('currency_sub_unit') }}
        </li>

        <li>
            {{ Form::label('region_code', 'Region_code:') }}
            {{ Form::text('region_code') }}
        </li>

        <li>
            {{ Form::label('sub_region_code', 'Sub_region_code:') }}
            {{ Form::text('sub_region_code') }}
        </li>

        <li>
            {{ Form::label('eea', 'Eea:') }}
            {{ Form::checkbox('eea') }}
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


