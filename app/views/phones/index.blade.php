@extends('layouts.scaffold')

@section('main')

<h1>All Phones</h1>

<p>{{ link_to_route('phones.create', 'Add new phone') }}</p>

@if ($phones->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Number</th>
				<th>Imei</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($phones as $phone)
				<tr>
					<td>{{{ $phone->number }}}</td>
					<td>{{{ $phone->imei }}}</td>
                    <td>{{ link_to_route('phones.edit', 'Edit', array($phone->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('phones.destroy', $phone->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no phones
@endif

@stop
