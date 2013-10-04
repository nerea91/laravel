@extends('layouts.scaffold')

@section('main')

<h1>All Countries</h1>

<p>{{ link_to_route('countries.create', 'Add new country') }}</p>

@if ($countries->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Full_name</th>
				<th>Iso_3166_2</th>
				<th>Iso_3166_3</th>
				<th>Country_code</th>
				<th>Capital</th>
				<th>Citizenship</th>
				<th>Currency</th>
				<th>Currency_code</th>
				<th>Currency_sub_unit</th>
				<th>Region_code</th>
				<th>Sub_region_code</th>
				<th>Eea</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($countries as $country)
				<tr>
					<td>{{{ $country->name }}}</td>
					<td>{{{ $country->full_name }}}</td>
					<td>{{{ $country->iso_3166_2 }}}</td>
					<td>{{{ $country->iso_3166_3 }}}</td>
					<td>{{{ $country->country_code }}}</td>
					<td>{{{ $country->capital }}}</td>
					<td>{{{ $country->citizenship }}}</td>
					<td>{{{ $country->currency }}}</td>
					<td>{{{ $country->currency_code }}}</td>
					<td>{{{ $country->currency_sub_unit }}}</td>
					<td>{{{ $country->region_code }}}</td>
					<td>{{{ $country->sub_region_code }}}</td>
					<td>{{{ $country->eea }}}</td>
                    <td>{{ link_to_route('countries.edit', 'Edit', array($country->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('countries.destroy', $country->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no countries
@endif

@stop
