@extends('layouts.scaffold')

@section('main')

<h1>Show Phone</h1>

<p>{{ link_to_route('phones.index', 'Return to all phones') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Number</th>
				<th>Imei</th>
		</tr>
	</thead>

	<tbody>
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
	</tbody>
</table>

@stop
